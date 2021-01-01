<?php

namespace app\modules\api\controllers;

use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * User controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => User::find()->select("id, username, displayName, contact, email, status, created_at, updated_at, idAccessPoint, currentEvent"),
            'pagination' => false
        ]);
    }

    public function actionView($id)
    {
        $activeData = new ActiveDataProvider([
            'query' => User::find()->select("id, username, displayName, contact, email, status, created_at, updated_at, idAccessPoint, currentEvent")->where("id = " . $id),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new NotFoundHttpException("User not found!");
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
