<?php

namespace app\modules\api\controllers;

use common\models\Area;
use common\models\Credential;
use common\models\Movement;
use common\models\User;
use DateTime;
use http\Exception\InvalidArgumentException;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
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
        unset($actions['index'], $actions['update'], $actions['view'], $actions['delete'], $actions['create']);
        return $actions;
    }

    public function actionIndex()
    {
        $moves = \common\models\Movement::find()->orderBy(['time' => SORT_DESC])->all();

        foreach ($moves as $key => $mov) {
            $moves[$key] = (object)array_merge((array)$moves[$key]->attributes,
                ["idEvent" => $mov->idAreaFrom0->idEvent],
                ["nameAreaFrom" => $mov->idAreaFrom0->name],
                ["nameAreaTo" => $mov->idAreaTo0->name],
                ["nameAccessPoint" => $mov->idAccessPoint0->name],
                ["nameUser" => (isset($mov->idUser0->displayName) ? $mov->idUser0->displayName : $mov->idUser0->username)],
                ["nameCredential" => (isset($mov->idCredential0->idCarrier0->name) ? $mov->idCredential0->idCarrier0->name : $mov->idCredential0->ucid)],
                ["lastMovement" => (Credential::findOne($mov->idCredential0->id)->getMovements()->orderBy(['time'=> SORT_DESC])->one()['id'] == $mov->id ? true : false)]);
        }
        if ($moves)
            return $moves;
        throw new HttpException(204,"Movements not found!");
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

    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        $post['time'] = date("Y-m-d H:i:s", time());

        $post['Movement'] = $post;
        $model = new Movement();
        if($model->load($post) && $model->save()){
            $cred = Credential::findOne($model->idCredential);
            $cred->idCurrentArea = $model->idAreaTo;
            $cred->save();

            return $model;
        }
        throw new BadRequestHttpException("Arguments missing!");
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
            if($rec->save() && Credential::findOne($rec->idCredential)->getMovements()->orderBy(['time'=> SORT_DESC])->one()['id'] == $rec->id){
                $cred = Credential::findOne($rec->idCredential);
                $cred->idCurrentArea = $rec->idAreaTo;
                $cred->save();
                $move = (object)array_merge((array)$rec->attributes,
                    ["idEvent" => $rec->idAreaFrom0->idEvent],
                    ["nameAreaFrom" => $rec->idAreaFrom0->name],
                    ["nameAreaTo" => $rec->idAreaTo0->name],
                    ["nameAccessPoint" => $rec->idAccessPoint0->name],
                    ["nameUser" => (isset($rec->idUser0->displayName) ? $rec->idUser0->displayName : $rec->idUser0->username)],
                    ["nameCredential" => (isset($rec->idCredential0->idCarrier0->name) ? $rec->idCredential0->idCarrier0->name : $rec->idCredential0->ucid)],
                    ["lastMovement" => (Credential::findOne($rec->idCredential0->id)->getMovements()->orderBy(['time'=> SORT_DESC])->one()['id'] == $rec->id ? true : false)]);

            }
            return $move;
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
