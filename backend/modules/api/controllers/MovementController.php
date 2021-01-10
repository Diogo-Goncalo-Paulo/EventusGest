<?php

namespace app\modules\api\controllers;

use common\models\Movement;
use common\models\User;
use DateTime;
use http\Exception\InvalidArgumentException;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class MovementController extends ActiveController
{
    public $modelClass = 'common\models\Movement';

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
        $moves = \common\models\Movement::find()->all();

        foreach ($moves as $key => $mov) {
            $moves[$key] = (object)array_merge((array)$moves[$key]->attributes, ["nameAreaFrom" => $mov->idAreaFrom0->name], ["nameAreaTo" => $mov->idAreaTo0->name], ["nameAccessPoint" => $mov->idAccessPoint0->name], ["nameUser" => (isset($mov->idUser0->displayName) ? $mov->idUser0->displayName : $mov->idUser0->username)]);
        }
        if ($moves)
            return $moves;
        throw new \yii\web\NotFoundHttpException("Movements not found!");
    }

    public function actionView($id) {
        $activeData = new ActiveDataProvider([
            'query' => \common\models\Movement::find()->where(['id' => $id]),
            'pagination' => false
        ]);

        if ($activeData->totalCount > 0)
            return $activeData;
        throw new \yii\web\NotFoundHttpException("Movements not found!");
    }

    public function actionCredential($id) {

        $moves = \common\models\Movement::find()->where(['idCredential' => $id])->all();

        foreach ($moves as $key => $mov) {
            $moves[$key] = (object)array_merge((array)$moves[$key]->attributes, ["nameAreaFrom" => $mov->idAreaFrom0->name], ["nameAreaTo" => $mov->idAreaTo0->name], ["nameAccessPoint" => $mov->idAccessPoint0->name]);
        }
        if ($moves)
            return $moves;
        throw new \yii\web\NotFoundHttpException("Movements not found!");
    }

    public function actionUpdate($id)
    {
        $idCredential = Yii::$app->request->post('idCredential');
        $idAccessPoint = Yii::$app->request->post('idAccessPoint');
        $idAreaFrom = Yii::$app->request->post('idAreaFrom');
        $idAreaTo = Yii::$app->request->post('idAreaTo');
        $idUser = Yii::$app->user->getId();

        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id])->one();

        if ($rec) {
            $rec->idCredential = $idCredential;
            $rec->idAccessPoint = $idAccessPoint;
            $rec->idAreaFrom = $idAreaFrom;
            $rec->idAreaTo = $idAreaTo;
            $rec->idUser = $idUser;
            $rec->save();
            return $rec;
        }
        throw new \yii\web\NotFoundHttpException("Movement not found!");
    }

    public function actionDelete($id)
    {
        if(Yii::$app->user->can('deleteMovement')){
            $model = new $this->modelClass;
            $rec = $model::find()->where(['id' => $id])->one();
            if ($rec) {
                $lastMovement = \common\models\Credential::findOne($rec->idCredential)->getMovements()->orderBy(['time'=> SORT_DESC])->one();

                if($lastMovement['id'] == $rec->id){
                    $rec->delete();
                    return ['Success' => 'Movement deleted successfully!'];
                }
                throw new \yii\web\UnauthorizedHttpException("The Movement you're trying to delete is not the latest one on this credential!");
            }
            throw new \yii\web\NotFoundHttpException("Movement not found!");
        }
        throw new \yii\web\UnauthorizedHttpException("You do not have permissions to delete movements!");


    }
}
