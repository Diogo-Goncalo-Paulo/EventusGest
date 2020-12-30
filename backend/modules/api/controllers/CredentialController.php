<?php

namespace app\modules\api\controllers;

use common\models\Credential;
use common\models\User;
use DateTime;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
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
        unset($actions['delete'], $actions['view'], $actions['index'], $actions['create'], $actions['update']);
        return $actions;
    }

   public function actionViewByUcid($ucid)
    {
        $activeData = new ActiveDataProvider([
            'query' => Credential::find()->where("deletedAt IS NULL AND ucid = " . $ucid ),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new NotFoundHttpException("Credential not found!");
    }

   public function actionView($id)
    {
        $activeData = new ActiveDataProvider([
            'query' => Credential::find()->where("deletedAt IS NULL AND id = " . $id ),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new NotFoundHttpException("Credential not found!");
    }

   public function actionIndex()
    {
        $activeData = new ActiveDataProvider([
            'query' => Credential::find()->where("deletedAt IS NULL"),
            'pagination' => false
        ]);
        if ($activeData->totalCount > 0)
            return $activeData;
        throw new NotFoundHttpException("Credentials not found!");
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

    public function actionFlag($id) {
        $model = Credential::find()->where("deletedAt IS NULL AND id = " . $id)->one();

        if ($model) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->updatedAt = $dateTime;
            $model->flagged++;

            if ($model->save())
                return $model;
            throw new ServerErrorHttpException("Failed to flag credential!");
        }
        throw new NotFoundHttpException("Credential not found!");
    }

    public function actionBlock($id) {
        $model = Credential::find()->where("deletedAt IS NULL AND id = " . $id)->one();
        if ($model) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->updatedAt = $dateTime;
            if ($model->blocked > 0 )
                throw new BadRequestHttpException("Failed to block credential, because it was already blocked!");
            else
                $model->blocked++;

            if ($model->save())
                return $model;
            throw new ServerErrorHttpException("Failed to block credential!");
        }
        throw new NotFoundHttpException("Credential not found!");
    }

    public function actionUnblock($id) {
        $model = Credential::find()->where("deletedAt IS NULL AND id = " . $id)->one();
        if ($model) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->updatedAt = $dateTime;
            if ($model->blocked > 0 )
                $model->blocked = 0;
            else
                throw new BadRequestHttpException("Failed to unblock credential, because it was not blocked in the first place!");

            if ($model->save())
                return $model;
            throw new ServerErrorHttpException("Failed to block credential!");
        }
        throw new NotFoundHttpException("Credential not found!");
    }

}
