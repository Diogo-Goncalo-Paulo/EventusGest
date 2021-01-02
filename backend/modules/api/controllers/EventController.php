<?php

namespace app\modules\api\controllers;

use common\models\Accesspoint;
use common\models\Area;
use common\models\Areaaccesspoint;
use common\models\Event;
use common\models\Eventuser;
use common\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\auth\HttpBasicAuth;
use DateTime;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class EventController extends ActiveController
{
    public $modelClass = 'common\models\Event';

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

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['create'], $actions['delete'], $actions['index']);
        return $actions;
    }

    public function actionCreate() {
        throw new \yii\web\MethodNotAllowedHttpException("This method is not allowed!");
    }

    public function actionIndex() {
        $events = Event::find()->where("deletedAt IS NULL")->all();

        foreach ($events as $key => $event) {
            $array = array();
            foreach ($event->getEventsusers()->select("idUsers")->all() as $user) {
                array_push($array, $user["idUsers"]);
            }

            $events[$key] = (object)array_merge((array)$events[$key]->attributes, ["users" => $array]);
        }

        if (count($events) > 0)
            return $events;
        throw new \yii\web\NotFoundHttpException("Events not found!");
    }


    public function actionNotselected() {
        $event = User::findOne(Yii::$app->user->id)->getEvent();

        $model = new $this->modelClass;
        $recs = $model::find()->where(['id' => $event, 'deletedAt' => 'NULL'])->all();

        if ($recs)
            return $recs;
        throw new \yii\web\NotFoundHttpException("Events not found!");
    }

    public function actionUser($name) {
        $user = User::find()->where(['username' => $name])->one();
        $eventusers = Eventuser::find()->select('idEvent')->where(['idUsers' => $user['id']]);

        $activeData = new ActiveDataProvider([
            'query' => \common\models\Event::find()->where("deletedAt IS NULL")->andWhere(['in', 'id', $eventusers]),
            'pagination' => false
        ]);

        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("User not found!");
    }

    public function actionUpdate($id) {
        $name=\Yii::$app->request->post('name');
        $startDate=\Yii::$app->request->post('startDate');
        $endDate=\Yii::$app->request->post('endDate');
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $updateAt = $dateTime;

        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id, 'deletedAt' => 'NULL'])->one();

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
