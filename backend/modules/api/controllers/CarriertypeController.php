<?php

namespace app\modules\api\controllers;

use common\models\User;
use DateTime;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

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
            'query' => \common\models\Carriertype::find()->where("deletedAt IS NULL AND id=" . $id . ""),
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
        $rec = $model::find()->where("deletedAt IS NULL AND id=" . $id)->one();

        if ($rec) {
            $rec->name = $name;
            $rec->updatedAt = $updatedAt;
            $rec->save();

            return ['Carrier type' => $rec];
        }
        throw new \yii\web\NotFoundHttpException("Carrier type not found!");
    }

    public function actionDelete($id) {
        $model = new $this->modelClass;
        $rec = $model::find()->where("deletedAt IS NULL AND id=" . $id)->one();
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
