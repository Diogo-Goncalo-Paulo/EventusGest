<?php

namespace app\modules\api\controllers;

use common\helpers\CorsCustom;
use common\models\Accesspoint;
use common\models\Area;
use common\models\Areaaccesspoint;
use common\models\Event;
use common\models\User;
use DateTime;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * Access Point controller for the `api` module
 */
class AccesspointController extends ActiveController
{
    public $modelClass = 'common\models\AccessPoint';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $authenticator = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth'],
            'except' => ['options']
        ];

        $behaviors['authenticator'] = array_merge($behaviors['authenticator'], $authenticator);

        $behaviors['corsFilter'] = [
            'class' => CorsCustom::className(),
//            'cors' => [
//                // restrict access to domains:
//                'Origin' => static::allowedDomains(),
//                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
//                'Access-Control-Request-Headers' => [' X-Requested-With'],
//                'Access-Control-Allow-Credentials' => true,
//                'Allow' => ['GET', 'POST', 'HEAD', 'OPTIONS'],
//                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
//            ],
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

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['update'], $actions['view'], $actions['delete'], $actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        throw new \yii\web\MethodNotAllowedHttpException("This method is not allowed!");
    }

    public function actionIndex()
    {
        $accesspoints = Accesspoint::find()->where("deletedAt IS NULL")->all();

        foreach ($accesspoints as $key => $accesspoint) {
            $array = array();
            foreach ($accesspoint->getIdAreas()->select("id")->all() as $area) {
                array_push($array, $area["id"]);
            }

            $accesspoints[$key] = (object)array_merge((array)$accesspoints[$key]->attributes, ["areas" => $array]);
        }

        if (count($accesspoints) > 0)
            return $accesspoints;
        throw new \yii\web\NotFoundHttpException("Access points not found!");
    }


    public function actionSearch()
    {
        $queryString = Yii::$app->request->get();

        if (!isset($queryString['q']))
            throw new BadRequestHttpException('Query Missing!');

        $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $accesspoints = Accesspoint::find()->where("deletedAt IS NULL")->andWhere(['like', 'name', $queryString['q']])->andWhere(['in', 'id', $subquery])->all();

        foreach ($accesspoints as $key => $accesspoint) {
            $array = array();
            foreach ($accesspoint->getIdAreas()->select("id")->all() as $area) {
                array_push($array, $area["id"]);
            }

            $accesspoints[$key] = (object)array_merge((array)$accesspoints[$key]->attributes, ["areas" => $array]);
        }

        if (count($accesspoints) > 0)
            return $accesspoints;
        throw new \yii\web\NotFoundHttpException("Access points not found!");
    }

    public function actionEvent($id)
    {
        $event = Event::find()->where(((int)$id ? ['id' => $id] : ['name' => $id]))->one();
        $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => $event->id]);
        $activeData = new ActiveDataProvider([
            'query' => \common\models\Accesspoint::find()->where("deletedAt IS NULL")->andWhere(['in', 'id', $subquery]),
            'pagination' => false
        ]);

        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Event not found!");
    }

    public function actionView($id)
    {
        $accesspoints = Accesspoint::find()->where(['id' => $id, 'deletedAt' => null])->all();

        foreach ($accesspoints as $key => $accesspoint) {
            $array = array();
            foreach ($accesspoint->getIdAreas()->select("id")->all() as $area) {
                array_push($array, $area["id"]);
            }

            $accesspoints[$key] = (object)array_merge((array)$accesspoints[$key]->attributes, ["areas" => $array]);
        }

        if (count($accesspoints) > 0)
            return $accesspoints[0];
        throw new \yii\web\NotFoundHttpException("Access point not found!");
    }

    public function actionArea($id)
    {
        $currentEvent = User::findOne(Yii::$app->user->id)->getEvent();

        $activeData = new ActiveDataProvider([
            'query' => Area::find()->where(['idEvent' => $currentEvent, 'deletedAt' => null])->andWhere('id NOT LIKE ' . $id),
            'pagination' => false
        ]);

        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Area not found!");
    }

    public function actionUpdate($id)
    {
        $name = \Yii::$app->request->post('name');
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $updatedAt = $dateTime;

        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id, 'deletedAt' => null])->one();

        if ($rec) {
            $rec->name = $name;
            $rec->updatedAt = $updatedAt;
            if ($rec->save())
                return $rec;
            throw new ServerErrorHttpException("An error has occurred while trying to save!");
        }
        throw new \yii\web\NotFoundHttpException("Access point not found!");
    }

    public function actionDelete($id)
    {
        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id, 'deletedAt' => null])->one();
        if ($rec) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $rec->deletedAt = $dateTime;
            $rec->save();
            return ['Success' => 'Access point deleted successfully!'];
        }
        throw new \yii\web\NotFoundHttpException("Access point not found!");
    }
}
