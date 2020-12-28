<?php

namespace app\modules\api\controllers;

use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `api` module
 */
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
}
