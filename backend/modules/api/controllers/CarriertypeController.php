<?php

namespace app\modules\api\controllers;

use common\models\User;
use DateTime;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `api` module
 */
class CarriertypeController extends ActiveController
{
    public $modelClass = 'common\models\Carriertype';

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

    public function actionDeletecarriertype($id) {
        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id])->one();
        if($rec) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $rec->deletedAt = $dateTime;
            $rec->save();
            return ['Success' => 'Carrier type deleted successfully!'];
        }
        throw new \yii\web\NotFoundHttpException("Carrier type not found!");
    }
}
