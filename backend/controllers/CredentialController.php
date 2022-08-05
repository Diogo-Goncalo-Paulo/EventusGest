<?php

namespace backend\controllers;

use common\models\Area;
use common\models\Entity;
use common\models\Entitytype;
use common\models\Event;
use common\models\User;
use DateTime;
use Yii;
use common\models\Credential;
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
                        'actions' => ['update', 'error', 'email-all-entities-credentials'],
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
        $dataProvider->query->andWhere(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()]);

        $credentials = Credential::find()->andWhere(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();

        $subQuery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $entity = Entity::find()->where(['deletedAt' => null])->andWhere(['in','idEntityType', $subQuery])->all();

        $area = Area::find()->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'credentials' => $credentials,
            'entity' => $entity,
            'area' => $area,
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
        $credentials = array();

        if ($model->load(Yii::$app->request->post())) {
            do{
                $model->ucid = Yii::$app->security->generateRandomString(8);
            }while(!$model->validate(['ucid']));
            $model->idEvent = Yii::$app->user->identity->getEvent();
            $model->flagged = 0;
            $model->blocked = 0;
            $model->idCurrentArea = Event::findOne(User::findOne(Yii::$app->user->id)->getEvent())->default_area;
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->createdAt = $dateTime;
            $model->updatedAt = $dateTime;

            $model->createQrCode(330, 15);

            if($model->save())
                array_push($credentials,$model);

                $currentEvent = Event::findOne($model->idEvent);
                if($currentEvent->sendEmails == true)
                    $this->sendEmail($model->idEntity0,$credentials);

                return $this->redirect(['view', 'id' => $model->id]);
        }

        $subquery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $entity = Entity::find()->where(['deletedAt' => null])->andWhere(['in','idEntityType',$subquery])->all();
        return $this->render('create', [
            'model' => $model,
            'entity' => $entity,
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
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->updatedAt = $dateTime;

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        $subquery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $entity = Entity::find()->where(['deletedAt' => null])->andWhere(['in','idEntityType',$subquery])->all();
        return $this->render('update', [
            'model' => $model,
            'entity' => $entity,
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
        $carrier = $model->idCarrier0;
        if (isset($carrier)) {
            $carrier->deletedAt = $dateTime;
            $carrier->save();
        }
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

    public function actionEmailAllEntitiesCredentials() {
        $subQuery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $entities = Entity::find()->andWhere(['deletedAt' => null])->andWhere(['in','idEntityType', $subQuery])->all();

        foreach ($entities as $entity) {
            $credentials = Credential::find()->andWhere(['deletedAt' => null])->andWhere(['idEntity' => $entity->id])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();
            $this->sendEmail($entity, $credentials);
        }

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

    protected function sendEmail($entity,$credentials)
    {
        $message = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'sendMultipleCredentials-html', 'text' => 'sendMultipleCredentials-text'],
                ['entity' => $entity,'credentials'=>$credentials]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($entity->email)
            ->setSubject('Credenciais registadas em ' . $entity->name);


        foreach ($credentials as $credential){
            $message->attach(Yii::getAlias('@frontend').'/web/qrcodes/' . $credential->ucid . '.png');
        }

        $message->send();
    }
}
