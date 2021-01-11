<?php

namespace backend\controllers;

use common\models\Entitytypeareas;
use DateTime;
use Yii;
use common\models\EntityType;
use app\models\EntityTypeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EntityTypeController implements the CRUD actions for EntityType model.
 */
class EntitytypeController extends Controller
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
                        'actions' => ['create', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('createEntitytype'),
                    ],
                    [
                        'actions' => ['index', 'view', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('viewEntitytype'),
                    ],
                    [
                        'actions' => ['update', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('updateEntitytype'),
                    ],
                    [
                        'actions' => ['delete', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('deleteEntitytype'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all EntityType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntityTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EntityType model.
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
     * Creates a new EntityType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EntityType();

        if ($model->load(Yii::$app->request->post())) {

            $model->idEvent = Yii::$app->user->identity->getEvent();
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->createdAt = $dateTime;
            $model->updatedAt = $dateTime;

            if($model->save())
                $areas = Yii::$app->request->post()['Entitytype']['areas'];
                foreach ($areas as $area){
                    $entitytypearea = new Entitytypeareas();
                    $entitytypearea->idEntityType = $model->id;
                    $entitytypearea->idArea = $area;
                    $entitytypearea->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EntityType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->idEvent = Yii::$app->user->identity->getEvent();
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->createdAt = $dateTime;
            $model->updatedAt = $dateTime;

            if($model->save())
                $areas = Yii::$app->request->post()['Entitytype']['areas'];
            foreach ($areas as $area){
                $entitytypearea = new Entitytypeareas();
                $entitytypearea->idEntityType = $model->id;
                $entitytypearea->idArea = $area;
                $entitytypearea->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EntityType model.
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
     * Finds the EntityType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EntityType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntityType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
