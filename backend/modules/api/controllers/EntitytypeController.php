<?php

namespace app\modules\api\controllers;

use common\models\Entitytype;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * Entitytype controller for the `api` module
 */
class EntitytypeController extends ActiveController
{
    public $modelClass = 'common\models\Entitytype';

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

    public function actionIndex()
    {
        $activeData = new ActiveDataProvider([
            'query' => Entitytype::find()->where("deletedAt IS NULL"),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Entity types not found!");
    }

    public function actionView($id) {
        $activeData = new ActiveDataProvider([
            'query' => Entitytype::find()->where(['id' => $id, 'deletedAt' => 'NULL']),
            'pagination' => false
        ]);

        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Entity type not found!");
    }

    public function actionUpdate() {
        throw new MethodNotAllowedHttpException("Only GET is allowed!");
    }

    public function actionCreate() {
        throw new MethodNotAllowedHttpException("Only GET is allowed!");
    }

    public function actionDelete() {
        throw new MethodNotAllowedHttpException("Only GET is allowed!");
    }
}