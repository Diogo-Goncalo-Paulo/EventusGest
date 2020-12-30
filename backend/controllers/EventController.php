<?php

namespace backend\controllers;

use common\models\Accesspoint;
use common\models\Area;
use common\models\Areaaccesspoint;
use common\models\Eventuser;
use common\models\User;
use Yii;
use common\models\Event;
use app\models\EventSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('createEvent'),
                    ],
                    [
                        'actions' => ['index', 'view', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('viewEvent'),
                    ],
                    [
                        'actions' => ['update', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('updateEvent'),
                    ],
                    [
                        'actions' => ['delete', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('deleteEvent'),
                    ],
                ],
            ],

        ];
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $subquery = Eventuser::find()->select('idEvent')->where(['idUsers' => Yii::$app->user->id]);
        $dataProvider->query->where(['in', 'id', $subquery]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
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
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $rua = new Area();
            $rua->name = "Rua";
            $rua->idEvent = $model->id;
            $rua->save();

            $model->default_area = $rua->id;
            $model->save();

            $recinto = new Area();
            $recinto->name = "Recinto";
            $recinto->idEvent = $model->id;
            $recinto->save();

            $accesspoint = new Accesspoint();
            $accesspoint->name = "Ponto de Acesso 1";
            $accesspoint->save();

            $areaaccesspoint1 = new Areaaccesspoint();
            $areaaccesspoint1->idArea = $rua->id;
            $areaaccesspoint1->idAccessPoint = $accesspoint->id;
            $areaaccesspoint1->save();

            $areaaccesspoint2 = new Areaaccesspoint();
            $areaaccesspoint2->idArea = $recinto->id;
            $areaaccesspoint2->idAccessPoint = $accesspoint->id;
            $areaaccesspoint2->save();

            $user = User::findOne(Yii::$app->user->id);
            $user->currentEvent = $model->id;
            $user->idAccessPoint = $accesspoint->id;
            $user->save();

            if (isset(Yii::$app->request->post()['Event']['users'])) {
                $idUsers = Yii::$app->request->post()['Event']['users'];

                foreach($idUsers as $idUser) {
                    $eventUsers = new Eventuser();
                    $eventUsers->idEvent = $model->id;
                    $eventUsers->idUsers = $idUser;
                    $eventUsers->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (isset(Yii::$app->request->post()['Event']['users'])) {
                $oldEventUsers = Eventuser::find()->where('idEvent =' . Yii::$app->request->get('id') . '')->all();
                $newEventUsers = Yii::$app->request->post()['Event']['users'];

                foreach ($oldEventUsers as $oldEventUser) {
                    $oldEventUser->delete();
                }

                foreach ($newEventUsers as $newEventUser) {
                    $eventUser = new Eventuser();
                    $eventUser->idEvent = $model->id;
                    $eventUser->idUsers = $newEventUser;
                    $eventUser->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
