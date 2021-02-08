<?php

namespace backend\controllers;

use common\models\Accesspoint;
use common\models\Areaaccesspoint;
use common\models\Event;
use common\models\Eventuser;
use frontend\models\SignupForm;
use Yii;
use common\models\User;
use app\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('viewUsers'),
                    ],
                    [
                        'actions' => ['create', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('createUsers'),
                    ],
                    [
                        'actions' => ['update', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('updateUsers'),
                    ],
                    [
                        'actions' => ['delete', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('deleteUsers'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $subquery = Eventuser::find()->select('idEvent')->where(['idUsers' => Yii::$app->user->id]);
        $events = Event::find()->where(['deletedAt' => null])->andWhere(['in', 'id', $subquery])->all();
        $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $accessPoints = Accesspoint::find()->where(['deletedAt' => null])->andWhere(['in', 'id', $subquery])->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'events' => $events,
            'accessPoints' => $accessPoints,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Novo utilizador criado com sucesso!');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $auth= Yii::$app->authManager;
            if (isset(Yii::$app->request->post()['User']['role'])) {
                $newRole = $auth->getRole(Yii::$app->request->post()['User']['role']);
                $user = User::findOne($id);
                if ($currentRole = $auth->getRole($user->role0)) {
                    $auth->revoke($currentRole,$id);
                }
                $auth->assign($newRole, $id);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $subquery = Eventuser::find()->select('idEvent')->where(['idUsers' => Yii::$app->user->id]);
        $events = Event::find()->where(['deletedAt' => null])->andWhere(['in', 'id', $subquery])->all();
        $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $accessPoints = Accesspoint::find()->where(['deletedAt' => null])->andWhere(['in', 'id', $subquery])->all();
        return $this->render('update', [
            'model' => $model,
            'events' => $events,
            'accessPoints' => $accessPoints,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        $user->status != 0 ? $user->status = 0 : $user->status = 10;
        $user->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
