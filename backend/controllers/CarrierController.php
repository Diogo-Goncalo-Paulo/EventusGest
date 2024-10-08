<?php

namespace backend\controllers;

use common\models\Carriertype;
use common\models\Entitytype;
use common\models\Movement;
use common\models\UploadPhoto;
use DateTime;
use Yii;
use common\models\Carrier;
use app\models\CarrierSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CarrierController implements the CRUD actions for Carrier model.
 */
class CarrierController extends Controller
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
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('viewCarrier'),
                    ],
                    [
                        'actions' => ['create', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('createCarrier'),
                    ],
                    [
                        'actions' => ['update', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('updateCarrier'),
                    ],
                    [
                        'actions' => ['delete', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('deleteCarrier'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Carrier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CarrierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $subquery = Carriertype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $dataProvider->query->andWhere(['deletedAt' => null])->andWhere(['in', 'idCarrierType', $subquery]);
        $credential = \common\models\Credential::find()->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'credential' => $credential,
        ]);
    }

    /**
     * Displays a single Carrier model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $carrier = Carrier::findOne($id);
        $movements = Movement::find()->where(['idCredential' => $carrier->idCredential])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'movements' => $movements,
        ]);
    }

    /**
     * Creates a new Carrier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Carrier();
        $modelUp = new UploadPhoto();

        if ($model->load(Yii::$app->request->post()) && $modelUp->load(Yii::$app->request->post())) {

            $modelUp->photoFile = UploadedFile::getInstance($modelUp, 'photoFile');

            if ($modelUp->photoFile != null) {
                do {
                    $model->photo = Yii::$app->security->generateRandomString(8) . '.' . $modelUp->photoFile->extension;
                } while (!$model->validate('photo'));
                $modelUp->upload($model->photo, 'carriers');
            }

            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->createdAt = $dateTime;
            $model->updatedAt = $dateTime;
            if ($model->save()) {

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelUp' => $modelUp,
        ]);
    }

    /**
     * Updates an existing Carrier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUp = new UploadPhoto();

        if ($model->load(Yii::$app->request->post()) && $modelUp->load(Yii::$app->request->post())) {

            $modelUp->photoFile = UploadedFile::getInstance($modelUp, 'photoFile');

            if ($modelUp->photoFile != null) {
                if ($model->photo == null) {
                    do {
                        $model->photo = Yii::$app->security->generateRandomString(8) . '.' . $modelUp->photoFile->extension;
                    } while (!$model->validate('photo'));
                }
                $modelUp->upload($model->photo, 'carriers');
            }

            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->updatedAt = $dateTime;
            if ($model->save()) {

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $subquery = \common\models\Carrier::find()->select('idCredential');
        $query = \common\models\Credential::find()->where(['not in','id' , $subquery]);
        $models = $query->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();

        $idCredential = Yii::$app->request->get('idCredential');

        if(isset($idCredential)){
            $credential = \common\models\Credential::findOne($idCredential);
        }

        return $this->render('update', [
            'model' => $model,
            'modelUp' => $modelUp,
            'models' => $models,
            'credential' => isset($idCredential) ? $credential : 0,
        ]);
    }

    /**
     * Deletes an existing Carrier model.
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
     * Finds the Carrier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Carrier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carrier::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
