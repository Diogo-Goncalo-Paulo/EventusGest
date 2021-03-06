<?php

namespace backend\controllers;

use common\models\Area;
use common\models\Areaaccesspoint;
use common\models\User;
use DateTime;
use Yii;
use common\models\Accesspoint;
use app\models\AccesspointSearch;
use yii\filters\AccessControl;
use yii\helpers\BaseVarDumper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccesspointController implements the CRUD actions for Accesspoint model.
 */
class AccesspointController extends Controller
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
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('viewAccessPoint'),
                    ],
                    [
                        'actions' => ['create', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('createAccessPoint'),
                    ],
                    [
                        'actions' => ['update', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('updateAccessPoint'),
                    ],
                    [
                        'actions' => ['delete', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('deleteAccessPoint'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Accesspoint models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccesspointSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $dataProvider->query->andWhere(['deletedAt' => null])->andWhere(['in', 'id', $subquery]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Accesspoint model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Accesspoint model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Accesspoint();

        if (isset(Yii::$app->request->post()['Accesspoint']['area1']) && isset(Yii::$app->request->post()['Accesspoint']['area2'])) {
            $idAreas = array(Yii::$app->request->post()['Accesspoint']['area1'], Yii::$app->request->post()['Accesspoint']['area2']);

            if ($idAreas[0] != $idAreas[1]) {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    $auth = Yii::$app->authManager;

                    if ($idAreas[0] != $idAreas[1]) {
                        foreach ($idAreas as $idArea) {
                            $modelrelation = new Areaaccesspoint();
                            $modelrelation->idArea = $idArea;
                            $modelrelation->idAccessPoint = $model->id;
                            $modelrelation->save();
                        }

                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        $areas = Area::find()->where(['deletedAt' => null,'idEvent' => Yii::$app->user->identity->getEvent()])->all();
        return $this->render('create', [
            'areas' => $areas,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Accesspoint model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (isset(Yii::$app->request->post()['Accesspoint']['area1']) && isset(Yii::$app->request->post()['Accesspoint']['area2'])) {
                $idAreas = array(Yii::$app->request->post()['Accesspoint']['area1'], Yii::$app->request->post()['Accesspoint']['area2']);
                $modelrelations = Areaaccesspoint::find()->where('idAccessPoint =' . $model->id . '')->all();
                foreach ($modelrelations as $modelrelation) {
                    foreach ($idAreas as $idArea) {
                        $modelrelation->idArea = $idArea;
                        $modelrelation->idAccessPoint = $model->id;
                        $modelrelation->save();
                    }
                }

            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $areas = Area::find()->where(['deletedAt' => null,'idEvent' => Yii::$app->user->identity->getEvent()])->all();
        return $this->render('update', [
            'model' => $model,
            'areas' => $areas
        ]);
    }

    /**
     * Deletes an existing Accesspoint model.
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
     * Finds the Accesspoint model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accesspoint the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Accesspoint::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
