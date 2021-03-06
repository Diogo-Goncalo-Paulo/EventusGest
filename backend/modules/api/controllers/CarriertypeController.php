<?php

namespace app\modules\api\controllers;

use common\models\User;
use DateTime;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

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
            throw new UnauthorizedHttpException("Wrong credentials!");
        }
        throw new NotFoundHttpException("User not found!");
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['update'], $actions['view'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $activeData = new ActiveDataProvider([
            'query' => \common\models\Carriertype::find()->where("deletedAt IS NULL"),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Carrier type not found!");
    }

    public function actionView($id) {
        $activeData = new ActiveDataProvider([
            'query' => \common\models\Carriertype::find()->where(['id' => $id, 'deletedAt' => null]),
            'pagination' => false
        ]);

        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Carrier type not found!");
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
            $rec->save();

            return $rec;
        }
        throw new \yii\web\NotFoundHttpException("Carrier type not found!");
    }

    public function actionDelete($id) {
        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id, 'deletedAt' => null])->one();
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
