<?php

namespace app\modules\api\controllers;

use common\models\Accesspoint;
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
            'query' => User::find()->select($this->columns)->where("id = " . $id),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new NotFoundHttpException("User not found!");
    }

    public function actionEvent($id) {
        $model = new $this->modelClass;
        $rec = $model::find()->select($this->columns)->where("id=" . $id)->one();
        if ($rec) {
            $ev = \Yii::$app->request->post('eventId');
            if (!isset($ev))
                throw new HttpException(422, "The field eventId is required!");
            $event = Event::findOne($ev);
            if ($event) {
                foreach ($event->getEventsusers()->all() as $user) {
                    if ($user->idUsers == $id) {
                        $rec->currentEvent = $ev;
                        if ($rec->save())
                            return $rec;
                        throw new ServerErrorHttpException("An error has occurred!");
                    }
                }
                throw new ForbiddenHttpException("The user does not have access to this event");
            }
            throw new NotFoundHttpException("Event not found!");
        }
        throw new NotFoundHttpException("User type not found!");
    }

    public function actionAccesspoint($id) {
        $model = new $this->modelClass;
        $rec = $model::find()->select($this->columns)->where("id=" . $id)->one();
        if ($rec) {
            $ap = Yii::$app->request->post('accessPointId');
            if (!isset($ap))
                throw new HttpException(422,"The field accessPointId is required!");
            $accessPoint = Accesspoint::findOne($ap);
            if ($accessPoint) {
                if ($accessPoint->getIdAreas()->all()[0]->idEvent != $rec->currentEvent)
                    throw new ForbiddenHttpException("The access point must be from an area in the user's current event");
                $rec->idAccessPoint = $ap;
                if ($rec->save())
                    return $rec;
                throw new ServerErrorHttpException("An error has occurred!");
            }
            throw new NotFoundHttpException("Access Point not found!");
        }
        throw new NotFoundHttpException("User type not found!");
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
