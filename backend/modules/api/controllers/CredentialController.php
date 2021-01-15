<?php

namespace app\modules\api\controllers;

use common\models\Carrier;
use common\models\Credential;
use common\models\User;
use DateTime;
use Exception;
use PhpMqtt\Client\MQTTClient;
use stdClass;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * Credential controller for the `api` module
 */
class CredentialController extends ActiveController
{
    public $modelClass = 'common\models\Credential';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['view'], $actions['index'], $actions['create'], $actions['update']);
        return $actions;
    }

    public function actionViewbyucid($ucid)
    {
        $activeData = new ActiveDataProvider([
            'query' => Credential::find()->where(['ucid' => $ucid, 'deletedAt' => null]),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new NotFoundHttpException("Credential not found!");
    }

    public function actionView($id)
    {
        $creds = Credential::find()->where(['id' => $id, 'deletedAt' => null])->all();

        foreach ($creds as $key => $cred) {
            $array = array();
            foreach ($cred->idEntity0->idEntityType0->idAreas as $area) {
                array_push($array, $area["id"]);
            }
            $creds[$key] = (object)array_merge((array)$creds[$key]->attributes, ["accessibleAreas" => $array, 'entity' => $cred->idEntity0, 'carrier' => $cred->idCarrier0]);
        }

        if (count($creds) > 0)
            return $creds;
        throw new NotFoundHttpException("Credential not found!");
    }

    public function actionIndex()
    {
        $creds = Credential::find()->where(['deletedAt' => null])->all();

        foreach ($creds as $key => $cred) {
            $array = array();
            foreach ($cred->idEntity0->idEntityType0->idAreas as $area) {
                array_push($array, $area["id"]);
            }
            $carrier = $cred->idCarrier0;
            if ($carrier != null) {
                if ($carrier->photo != null)
                    $carrier->photo = Yii::$app->request->baseUrl . '/uploads/carriers/' . $carrier->photo;

                $carrier = (object)array_merge((array)$carrier->attributes, ['carrierType' => $carrier->idCarrierType0]);
            }
            $qrcode = Yii::$app->request->baseUrl . '/qrcodes/' . $cred->ucid . '.png';
            $creds[$key] = (object)array_merge((array)$creds[$key]->attributes, ["accessibleAreas" => $array, 'qrcode' => $qrcode, 'entity' => $cred->idEntity0, 'carrier' => $carrier]);
        }

        if (count($creds) > 0)
            return $creds;
        throw new NotFoundHttpException("Credentials not found!");
    }

    public function actionSearch()
    {
        $queryString = Yii::$app->request->get();

        if (!isset($queryString['q']))
            throw new BadRequestHttpException('Query Missing!');

        $creds = Credential::find()->where("deletedAt IS NULL")->andWhere(['like', 'ucid', $queryString['q']])->all();

        foreach ($creds as $key => $cred) {
            $array = array();
            foreach ($cred->idEntity0->idEntityType0->idAreas as $area) {
                array_push($array, $area["id"]);
            }
            $creds[$key] = (object)array_merge((array)$creds[$key]->attributes, ["accessibleAreas" => $array]);
        }

        if (count($creds) > 0)
            return $creds;
        throw new NotFoundHttpException("Credentials not found!");
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];
        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user) {
            if ($user->validatePassword($password))
                return $user;
            throw new UnauthorizedHttpException("Wrong credentials!");
        }
        throw new NotFoundHttpException("User not found!");
    }

    public function actionFlag($id)
    {
        $model = Credential::find()->where(['id' => $id, 'deletedAt' => null])->one();

        if ($model) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->updatedAt = $dateTime;
            $model->flagged++;

            if ($model->save()) {
                $this->mqttPublish($id, "flag");
                return $model;
            }
            throw new ServerErrorHttpException("Failed to flag credential!");
        }
        throw new NotFoundHttpException("Credential not found!");
    }

    public function actionBlock($id)
    {
        $model = Credential::find()->where(['id' => $id, 'deletedAt' => null])->one();
        if ($model) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->updatedAt = $dateTime;
            if ($model->blocked > 0)
                throw new BadRequestHttpException("Failed to block credential, because it was already blocked!");
            else
                $model->blocked++;

            if ($model->save()) {
                $this->mqttPublish($id, "block");
                return $model;
            }
            throw new ServerErrorHttpException("Failed to block credential!");
        }
        throw new NotFoundHttpException("Credential not found!");
    }

    public function actionUnblock($id)
    {
        $model = Credential::find()->where(['id' => $id, 'deletedAt' => null])->one();
        if ($model) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->updatedAt = $dateTime;
            if ($model->blocked > 0)
                $model->blocked = 0;
            else
                throw new BadRequestHttpException("Failed to unblock credential, because it was not blocked in the first place!");

            if ($model->save()) {
                $this->mqttPublish($id, "unblock");
                return $model;
            }
            throw new ServerErrorHttpException("Failed to block credential!");
        }
        throw new NotFoundHttpException("Credential not found!");
    }

    public function actionCreate()
    {
        throw new MethodNotAllowedHttpException("Only GET is allowed!");
    }

    public function actionUpdate()
    {
        throw new MethodNotAllowedHttpException("Only GET is allowed!");
    }

    public function actionDelete()
    {
        throw new MethodNotAllowedHttpException("Only GET is allowed!");
    }

    public function mqttPublish($id, $action)
    {
        $server = '127.0.0.1';
        $port = 1883;
        $topic = "eventusGest";
        $clientId = 'servicesEG';

        $msg = new stdClass();
        $msg->credentialId = $id;
        $msg->action = $action;
        $msgJSON = json_encode($msg);

        $mqtt = new MQTTClient($server, $port, $clientId);
        try {
            $mqtt->connect();
            $mqtt->publish($topic, $msgJSON, 0);
            $mqtt->close();
        } catch (Exception $exception) {
            throw new ServerErrorHttpException("Error while trying to publish to mqtt. Make sure that the broker is running!");
        }
    }
}
