<?php

namespace app\modules\api\controllers;

use common\models\User;
use DateTime;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * Area controller for the `api` module
 */
class AreaController extends ActiveController
{
    public $modelClass = 'common\models\Area';

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
            'query' => \common\models\Area::find()->where("deletedAt IS NULL"),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Areas not found!");
    }

    public function actionView($id) {
        $activeData = new ActiveDataProvider([
            'query' => \common\models\Area::find()->where(['id' => $id, 'deletedAt' => 'NULL']),
            'pagination' => false
        ]);

        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Area not found!");
    }

    public function actionUpdate($id)
    {
        $name = \Yii::$app->request->post('name');
        $resetTime = \Yii::$app->request->post('resetTime');
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $updatedAt = $dateTime;

        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id, 'deletedAt' => 'NULL'])->one();

        if ($rec) {
            $rec->name = $name;
            if (isset($resetTime))
                $rec->restartTime = $resetTime;
            $rec->updatedAt = $updatedAt;
            $rec->save();

            return ['Área' => $rec];
        }
        throw new \yii\web\NotFoundHttpException("Area not found!");
    }

    public function actionDelete($id)
    {
        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id, 'deletedAt' => 'NULL'])->one();
        if ($rec) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $rec->deletedAt = $dateTime;
            $rec->save();
            return ['Success' => 'Area deleted successfully!'];
        }
        throw new \yii\web\NotFoundHttpException("Area not found!");
    }
}
