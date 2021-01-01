<?php

namespace app\modules\api\controllers;

use common\models\Accesspoint;
use common\models\Area;
use common\models\Areaaccesspoint;
use common\models\Event;
use common\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use DateTime;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class EventController extends ActiveController
{
    public $modelClass = 'common\models\Event';

    /** @noinspection PhpDeprecationInspection */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];
        return $behaviors;
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user) {
            if ($user->validatePassword($password))
                return $user;
            throw new NotFoundHttpException("Wrong credentials!");
        }
        throw new NotFoundHttpException("User not found!");
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionCreate() {
        throw new \yii\web\MethodNotAllowedHttpException("This method is not allowed!");
    }

    public function actionNotselected() {
        $event = User::findOne(Yii::$app->user->id)->getEvent();

        $model = new $this->modelClass;
        $recs = $model::find()->where("deletedAt IS NULL AND id != ". $event)->all();

        if ($recs)
            return $recs;
        throw new \yii\web\NotFoundHttpException("Events not found!");
    }

    public function actionUpdate($id) {
        $name=\Yii::$app->request->post('name');
        $startDate=\Yii::$app->request->post('startDate');
        $endDate=\Yii::$app->request->post('endDate');
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $updateAt = $dateTime;

        $model = new $this->modelClass;
        $rec = $model::find()->where("deletedAt IS NULL AND id=".$id)->one();

        if($rec) {
            if(isset($name))
                $rec->name = $name;
            if(isset($startDate))
                $rec->startDate = $startDate;
            if(isset($endDate))
                $rec->endDate = $endDate;
            $rec->updateAt = $updateAt;
            $rec->save();

            return ['Evento' => $rec];
        }
        throw new \yii\web\NotFoundHttpException("Event not found!");
    }
}
