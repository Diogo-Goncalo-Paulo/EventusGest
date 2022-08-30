<?php

namespace backend\controllers;

use common\models\Credential;
use common\models\Entitytype;
use common\models\Event;
use DateTime;
use Yii;
use common\models\Entity;
use app\models\EntitySearch;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use ZipArchive;

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
                        'actions' => ['index', 'view', 'error', 'see-credentials', 'download-all-credentials', 'download-credentials'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('viewEntity'),
                    ],
                    [
                        'actions' => ['update', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('updateEntity'),
                    ],                    [
                        'actions' => ['regen-credentials', 'error'],
                        'allow' => !Yii::$app->user->isGuest && Yii::$app->user->can('updateCredential'),
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

        $ncreds = intval(Yii::$app->request->post('q'));

        if ($model->load(Yii::$app->request->post())) {
            do{
                $model->ueid = Yii::$app->security->generateRandomString(8);
            }while(!$model->validate(['ueid']));
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->createdAt = $dateTime;
            $model->updatedAt = $dateTime;
            if($model->save())
                if($ncreds > 0) {
                    for ($i = 0; $i < $ncreds; $i++){
                        $credential = new Credential();
                        $credential->idEntity = $model->id;
                        do {
                            $credential->ucid = Yii::$app->security->generateRandomString(8);
                        } while (!$credential->validate(['ucid']));
                        $credential->idEvent = $model->idEntityType0->idEvent;
                        $credential->flagged = 0;
                        $credential->blocked = 0;
                        $credential->idCurrentArea = Event::findOne($credential->idEvent)->default_area;
                        $dateTime = new DateTime('now');
                        $dateTime = $dateTime->format('Y-m-d H:i:s');
                        $credential->createdAt = $dateTime;
                        $credential->updatedAt = $dateTime;
                        $credential->createQrCode(330, 15);

                        $credential->save();
                    }
                }
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

    public function actionDownloadCredentials($id) {
        $entity = $this->findModel($id);
        $credentials = Credential::find()->andWhere(['deletedAt' => null])->andWhere(['idEntity' => $entity->id])->all();
        $zip = new ZipArchive();
        $zip->open(Yii::getAlias('@backend') . '/web/zips/' . 'credentials_' . $entity->ueid . '.zip', ZipArchive::CREATE);
        foreach($credentials as $credential) {
            $filePath = Yii::getAlias('@backend') . '/web/qrcodes/' . $credential->ucid . '.png';
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $credential->ucid . '.png');
            }
        }
        if ($zip->close()) {
            return Yii::$app->response->sendFile(Yii::getAlias('@backend') . '/web/zips/' . 'credentials_' . $entity->ueid . '.zip');
        } else {
            return $this->redirect(['error']);
        }

    }

    public function actionDownloadAllCredentials() {
        $subQuery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
        $entities = Entity::find()->andWhere(['deletedAt' => null])->andWhere(['in','idEntityType', $subQuery])->all();
        $zip = new ZipArchive();
        $zipPath = Yii::getAlias('@backend') . '/web/zips/credentials_all.zip';
        unlink($zipPath);
        $zip->open($zipPath, ZipArchive::CREATE);
        foreach($entities as $entity) {
            $credentials = $entity->credentials;
            // add folder for entity
            $zip->addEmptyDir($entity->ueid);
            foreach($credentials as $credential) {
                $filePath = Yii::getAlias('@backend') . '/web/qrcodes/' . $credential->ucid . '.png';
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $entity->ueid . '/' . $credential->ucid . '.png');
                }
            }
        }
        if ($zip->close()) {
            return Yii::$app->response->sendFile(Yii::getAlias('@backend') . '/web/zips/' . 'credentials_all.zip');
        } else {
            return $this->redirect(['error']);
        }
    }

    // a function to generate all QR codes for all the entity's credentials
    public function actionRegenCredentials($id) {
        $credentials = Credential::find()->where(['idEntity' => $id])->all();
        foreach($credentials as $credential) {
            $credential->createQrCode(330, 15);

            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $credential->updatedAt = $dateTime;
            $credential->save();
        }
        return $this->redirect(['view', 'id' => $id]);
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
