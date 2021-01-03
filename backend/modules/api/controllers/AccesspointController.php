<?php

namespace app\modules\api\controllers;

use common\models\Accesspoint;
use common\models\Areaaccesspoint;
use common\models\User;
use DateTime;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
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

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['update'], $actions['view'], $actions['delete'], $actions['create']);
        return $actions;
    }

    public function actionCreate() {
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

    public function actionEvent($id)
    {
        $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => $id]);
        $activeData = new ActiveDataProvider([
            'query' => \common\models\Accesspoint::find()->where("deletedAt IS NULL")->andWhere(['in', 'id', $subquery]),
            'pagination' => false
        ]);

        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Event not found!");
    }

    public function actionView($id) {
        $activeData = new ActiveDataProvider([
            'query' => \common\models\Accesspoint::find()->where(['id' => $id, 'deletedAt' => null]),
            'pagination' => false
        ]);

        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Access point not found!");
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

    public function actionDelete($id) {
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
