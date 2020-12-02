<?php

namespace backend\controllers;

use DateTime;
use Yii;
use app\models\Credential;
use app\models\CredentialSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CredentialController implements the CRUD actions for Credential model.
 */
class CredentialController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('viewCredential'),
                    ],
                    [
                        'actions' => ['create', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('createCredential'),
                    ],
                    [
                        'actions' => ['update', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('updateCredential'),
                    ],
                    [
                        'actions' => ['delete', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('deleteCredential'),
                    ],
                    [
                        'actions' => ['flag', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('flagCredential'),
                    ],
                    [
                        'actions' => ['block', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('blockCredential'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Credential models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CredentialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Credential model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Credential model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Credential();

        if ($model->load(Yii::$app->request->post())) {
            do{
                $model->ucid = Yii::$app->security->generateRandomString(8);
            }while(!$model->validate(['ucid']));
            $model->idEvent = Yii::$app->user->identity->getEvent();
            $model->flagged = 0;
            $model->blocked = 0;
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->createdAt = $dateTime;
            $model->updatedAt = $dateTime;

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Credential model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            do{
                $model->ucid = Yii::$app->security->generateRandomString(8);
            }while(!$model->validate(['ucid']));
            $model->idEvent = Yii::$app->user->identity->getEvent();
            $model->flagged = 0;
            $model->blocked = 0;
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->createdAt = $dateTime;
            $model->updatedAt = $dateTime;

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Credential model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $model = $this->findModel($id);
        $model->deletedAt = $dateTime;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Flags an existing Credential model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionFlag($id)
    {
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $model = $this->findModel($id);
        $model->updatedAt = $dateTime;
        $model->flagged++;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Blocks or Unblocks an existing Credential model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBlock($id)
    {
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $model = $this->findModel($id);
        $model->updatedAt = $dateTime;
        $model->blocked > 0 ? $model->blocked = 0 : $model->blocked++;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Credential model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Credential the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Credential::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
