<?php

namespace backend\controllers;

use common\models\Credential;
use common\models\Entitytype;
use DateTime;
use Yii;
use common\models\Entity;
use app\models\EntitySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EntityController implements the CRUD actions for Entity model.
 */
class EntityController extends Controller
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
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('createEntity'),
                    ],
                    [
                        'actions' => ['index', 'view', 'error', 'see-credentials'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('viewEntity'),
                    ],
                    [
                        'actions' => ['update', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('updateEntity'),
                    ],
                    [
                        'actions' => ['delete', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('deleteEntity'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Entity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $subQuery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $dataProvider->query->andWhere(['deletedAt' => null])->andWhere(['in','idEntityType', $subQuery]);

        $subQuery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $entity = Entity::find()->andWhere(['deletedAt' => null])->andWhere(['in','idEntityType', $subQuery])->all();

        $entityType = Entitytype::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->andWhere(['deletedAt' => null])->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'entity' => $entity,
            'entityType' => $entityType,
        ]);
    }

    /**
     * Displays a single Entity model.
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
     * Creates a new Entity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Entity();

        if ($model->load(Yii::$app->request->post())) {

            do{
                $model->ueid = Yii::$app->security->generateRandomString(8);
            }while(!$model->validate(['ueid']));
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->createdAt = $dateTime;
            $model->updatedAt = $dateTime;
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        $entityType = Entitytype::find()->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
        return $this->render('create', [
            'model' => $model,
            'entityType' => $entityType,
        ]);
    }

    /**
     * Updates an existing Entity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {


            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->updatedAt = $dateTime;

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        $entityType = Entitytype::find()->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
        return $this->render('update', [
            'model' => $model,
            'entityType' => $entityType,
        ]);
    }

    /**
     * Deletes an existing Entity model.
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

    public function actionSeeCredentials($ueid) {
        return $this->redirect(Yii::$app->urlManagerFrontend1->createUrl(['entity/view?ueid=' . $ueid]) . '&b=1');
    }

    /**
     * Finds the Entity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Entity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
