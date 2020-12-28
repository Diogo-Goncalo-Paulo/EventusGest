<?php

namespace app\modules\api\controllers;

use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

/**
 * User controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => User::find()->select("id, username, displayName, contact, email, status, created_at, updated_at, idAccessPoint, currentEvent"),
            'pagination' => false
        ]);
    }

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

    /** @noinspection PhpUnhandledExceptionInspection */
    public function actionDeleteuser($id)
    {
        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id])->one();
        if ($rec) {
            $rec->status != 0 ? $rec->status = 0 : $rec->status = 10;
            $rec->save();
            return ['Success' => 'User deleted successfully!'];
        }
        throw new NotFoundHttpException("User not found!");
    }

}
