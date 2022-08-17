<?php

namespace app\modules\api\controllers;

use common\helpers\CorsCustom;
use common\models\Accesspoint;
use common\models\Areaaccesspoint;
use common\models\Event;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * User controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
    private $columns = "id, username, displayName, contact, email, status, created_at, updated_at, idAccessPoint, currentEvent";

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => User::find()->select($this->columns),
            'pagination' => false
        ]);
    }

    public function actionView($id)
    {
        $activeData = new ActiveDataProvider([
            'query' => User::find()->select($this->columns)->where(['id' => $id]),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new NotFoundHttpException("User not found!");
    }

    public function actionViewbyusername($username)
    {
        $user = User::find()->select($this->columns)->where(['username' => $username])->one();

        if ($user) {
            $event = Event::findOne($user->currentEvent);
            $accessPoint = Accesspoint::findOne($user->idAccessPoint);
            $role = array_keys(Yii::$app->authManager->getRolesByUser($user->id))[0];
            $userArray = (array)$user->attributes;
            unset($userArray['auth_key'], $userArray['password_hash'], $userArray['password_reset_token'], $userArray['verification_token']);
            $userComp = (object)array_merge($userArray, ['role' => $role, "event" => $event, 'accessPoint' => $accessPoint]);
            return $userComp;
        }
        throw new NotFoundHttpException("User not found!");
    }

    public function actionEvent($id)
    {
        $model = new $this->modelClass;
        $rec = $model::find()->select($this->columns)->where(['id' => $id])->one();
        if ($rec) {
            $ev = \Yii::$app->request->post('eventId');
            if (isset($ev))
                $event = Event::findOne($ev);
            else {
                $evn = \Yii::$app->request->post('eventName');
                if (!isset($evn))
                    throw new HttpException(422, "The field eventId or eventName is required!");

                $event = Event::find()->where(['name' => $evn])->one();
            }
            if ($event) {
                foreach ($event->getEventsusers()->all() as $user) {
                    if ($user->idUsers == $id) {
                        $rec->currentEvent = $event->id;
                        $rec->idAccessPoint = null;
                        if ($rec->save()) {
                            return $this->actionViewbyusername($rec->username);
                        }
                        throw new ServerErrorHttpException("An error has occurred!");
                    }
                }
                throw new ForbiddenHttpException("The user does not have access to this event");
            }
            throw new NotFoundHttpException("Event not found!");
        }
        throw new NotFoundHttpException("User type not found!");
    }

    public function actionAccesspoint($id)
    {
        $model = new $this->modelClass;
        $rec = $model::find()->select($this->columns)->where(['id' => $id])->one();
        if ($rec) {
            $ap = Yii::$app->request->post('accessPointId');
            if (isset($ap))
                $accessPoint = Accesspoint::findOne($ap);
            else {
                $apn = Yii::$app->request->post('accessPointName');
                if (!isset($apn))
                    throw new HttpException(422, "The field accessPointId or accessPointName is required!");
                $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => $rec->currentEvent]);
                $accessPoint = Accesspoint::find()->where(['name' => $apn])->andWhere(['in', 'id', $subquery])->one();
            }
            if ($accessPoint) {
                if ($accessPoint->getIdAreas()->all()[0]->idEvent != $rec->currentEvent)
                    throw new ForbiddenHttpException("The access point must be from an area in the user's current event");
                $rec->idAccessPoint = $accessPoint->id;
                if ($rec->save())
                    return $this->actionViewbyusername($rec->username);;
                throw new ServerErrorHttpException("An error has occurred!");
            }
            throw new NotFoundHttpException("Access Point not found!");
        }
        throw new NotFoundHttpException("User type not found!");
    }

    /**
     * List of allowed domains.
     * Note: Restriction works only for AJAX (using CORS, is not secure).
     *
     * @return array List of domains, that can access to this API
     */
    public static function allowedDomains()
    {
        return [
            'http://app.eventusgest.live/',
            'https://app.eventusgest.live/',
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $authenticator = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];

        $behaviors['authenticator'] = array_merge($behaviors['authenticator'], $authenticator);

//        header('Access-Control-Allow-Origin: *');
//        header('Allow: GET, POST, HEAD, OPTIONS');

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to domains:
                'Origin' => static::allowedDomains(),
                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                'Access-Control-Request-Headers' => [' X-Requested-With'],
                'Access-Control-Allow-Credentials' => true,
                'Allow' => ['GET', 'POST', 'HEAD', 'OPTIONS'],
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                'Access-Control-Max-Age' => 3600,                 // Cache (seconds)
            ],
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

    public function actionDelete($id)
    {
        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id])->one();
        if ($rec) {
            $rec->status != 0 ? $rec->status = 0 : $rec->status = 10;
            $rec->save();
            return ['Success' => 'User status changed successfully to ' . $rec->status . '!'];
        }
        throw new NotFoundHttpException("User not found!");
    }

    public function actionCreate()
    {
        throw new MethodNotAllowedHttpException("Only GET and DELETE are allowed!");
    }

    public function actionUpdate()
    {
        throw new MethodNotAllowedHttpException("Only GET and DELETE are allowed!");
    }

}
