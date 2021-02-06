<?php

namespace backend\controllers;

use common\models\Accesspoint;
use common\models\Area;
use common\models\Areaaccesspoint;
use common\models\Credential;
use common\models\Entitytype;
use common\models\Eventuser;
use common\models\User;
use Yii;
use common\models\Movement;
use app\models\MovementSearch;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MovementController implements the CRUD actions for Movement model.
 */
class MovementController extends Controller
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
                        'actions' => ['view', 'error'],
                        'allow' => !Yii::$app->user->isGuest,
                    ],
                    [
                        'actions' => ['create', 'error'],
                        'allow' => !Yii::$app->user->isGuest,
                    ],
                    [
                        'actions' => ['index', 'error'],
                        'allow' => !Yii::$app->user->isGuest,
                    ],
                    [
                        'actions' => ['update', 'error'],
                        'allow' => !Yii::$app->user->isGuest,
                    ],
                    [
                        'actions' => ['delete', 'error'],
                        'allow' => !Yii::$app->user->isGuest,
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Movement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MovementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $subquery = Area::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $dataProvider->query->andWhere(['in','idAreaFrom', $subquery]);

        $credentials = Credential::find()->andWhere(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
        $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $accessPoint = Accesspoint::find()->andWhere(['deletedAt' => null])->andWhere(['in', 'id', $subquery])->all();
        $areas = Area::find()->andWhere(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
        $users = User::find()->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'credentials' => $credentials,
            'accessPoint' => $accessPoint,
            'areas' => $areas,
            'users' => $users,
        ]);
    }

    /**
     * Displays a single Movement model.
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
     * Creates a new Movement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionCreate()
    {
        $model = new Movement();
        if (Yii::$app->request->post()) {
            Movement::getDb()->transaction(function ($db) use ($model) {
                $data = Yii::$app->request->post();
                $credential = Credential::findOne($data['Movement']['idCredential']);
                $credential->idCurrentArea = $data['Movement']['idAreaTo'];

                $data['Movement']['time'] = date("Y-m-d H:i:s", time());
                $data['Movement']['idUser'] = Yii::$app->user->identity->getId();

                if ($model->load($data) && $model->save() && $credential->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }

                return $this->render('create', [
                    'model' => $model,
                ]);

            });
        }

        $credentials = Credential::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
        $accessPoint = Accesspoint::find()->where(['id' => Yii::$app->user->identity->getAccessPoint()])->all();
        $areas = Area::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
        return $this->render('create', [
            'model' => $model,
            'credentials' => $credentials,
            'accessPoint' => $accessPoint,
            'areas' => $areas,
        ]);
    }

    /**
     * Updates an existing Movement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $credentials = Credential::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
        $accessPoint = Accesspoint::find()->where(['id' => Yii::$app->user->identity->getAccessPoint()])->all();
        $areas = Area::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
        return $this->render('update', [
            'model' => $model,
            'credentials' => $credentials,
            'accessPoint' => $accessPoint,
            'areas' => $areas,
        ]);
    }

    /**
     * Deletes an existing Movement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $movement = Movement::findOne($id);
        $credential = Credential::findOne($movement->idCredential);
        $credential->idCurrentArea = $movement->idAreaFrom;
        $credential->save();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Movement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Movement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Movement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
