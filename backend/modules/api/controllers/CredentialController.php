<?php

namespace app\modules\api\controllers;

use common\models\User;
use http\Exception\BadMethodCallException;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * User controller for the `api` module
 */
class CredentialController extends ActiveController
{
    public $modelClass = 'common\models\Credential';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create'], $actions['update']);
        return $actions;
    }

    public function actionUpdate($id)
    {
        return $id;
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
            throw new UnauthorizedHttpException("Wrong credentials!");
        }
        throw new NotFoundHttpException("User not found!");
    }

}
