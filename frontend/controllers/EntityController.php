<?php

namespace frontend\controllers;

use common\models\Carrier;
use common\models\Credential;
use common\models\Entity;
use common\models\Event;
use common\models\UploadPhoto;
use DateTime;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class EntityController extends \yii\web\Controller
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
                    'delete-credential' => ['POST'],
                    'create-credential' => ['POST'],
                    'create-carrier' => ['POST'],
                    'update-carrier' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays a single Entity model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ueid)
    {
        $entity = Entity::find()->where(['=', 'ueid', $ueid])->one();
        if ($entity != null)
            return $this->render('view', [
                'model' => $entity,
            ]);
        else
            return $this->redirect(['index']);
    }

    /**
     * Updates an existing Entity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ueid)
    {
        $entity = Entity::find()->where(['=', 'ueid', $ueid])->one();
        if ($entity != null && $entity->ueid == $ueid) {
            if ($entity->load(Yii::$app->request->post())) {
                $dateTime = new DateTime('now');
                $dateTime = $dateTime->format('Y-m-d H:i:s');
                $entity->updatedAt = $dateTime;
                $entity->save();
            }
            return $this->redirect(['view', 'ueid' => $ueid]);
        } else
            return $this->redirect(['index']);
    }

    public function actionDeleteCredential($id, $ueid)
    {
        $credential = Credential::findOne($id);
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $credential->deletedAt = $dateTime;
        $credential->save();

        return $this->redirect(['view', 'ueid' => $ueid]);
    }

    public function actionCreateCredential($ueid)
    {
        $entity = Entity::findOne(['ueid' => $ueid]);
        $credentials = array();

        if (count($entity->credentials) < $entity->maxCredentials) {
            $credential = new Credential();
            $credential->idEntity = $entity->id;
            do {
                $credential->ucid = Yii::$app->security->generateRandomString(8);
            } while (!$credential->validate(['ucid']));
            $credential->idEvent = $entity->idEntityType0->idEvent;
            $credential->flagged = 0;
            $credential->blocked = 0;
            $credential->idCurrentArea = Event::findOne($credential->idEvent)->default_area;
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $credential->createdAt = $dateTime;
            $credential->updatedAt = $dateTime;
            $credential->createQrCode(150, 5);

            $credential->save();
            array_push($credentials,$credential);
            $this->sendEmail($entity,$credentials);

        }
        return $this->redirect(['view', 'ueid' => $ueid]);
    }

    public function actionCreateMultipleCredentials($ueid,$amount)
    {
        $entity = Entity::findOne(['ueid' => $ueid]);
        $credentials = array();

        if (count($entity->credentials)+$amount <= $entity->maxCredentials) {
            for ($i = 0; $i < $amount; $i++){
                $credential = new Credential();
                $credential->idEntity = $entity->id;
                do {
                    $credential->ucid = Yii::$app->security->generateRandomString(8);
                } while (!$credential->validate(['ucid']));
                $credential->idEvent = $entity->idEntityType0->idEvent;
                $credential->flagged = 0;
                $credential->blocked = 0;
                $credential->idCurrentArea = Event::findOne($credential->idEvent)->default_area;
                $dateTime = new DateTime('now');
                $dateTime = $dateTime->format('Y-m-d H:i:s');
                $credential->createdAt = $dateTime;
                $credential->updatedAt = $dateTime;
                $credential->createQrCode(150, 5);

                $credential->save();

                array_push($credentials,$credential);
            }

            $this->sendEmail($entity,$credentials);
        }
        return $this->redirect(['view', 'ueid' => $ueid]);
    }

    /**
     * Creates a new Carrier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateCarrier($ueid)
    {
        $entity = Entity::find()->where(['=', 'ueid', $ueid])->one();
        if ($entity != null) {

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
                $model->save();

            }
            return $this->redirect(['view', 'ueid' => $ueid]);
        } else
            return $this->redirect(['index']);
    }

    /**
     * Updates an existing Carrier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateCarrier($id, $ueid)
    {
        $entity = Entity::find()->where(['=', 'ueid', $ueid])->one();
        if ($entity != null) {
            $model = Carrier::findOne($id);
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
                $model->save();
            }
            return $this->redirect(['view', 'ueid' => $ueid]);
        } else
            return $this->redirect(['index']);
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
