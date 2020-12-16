<?php

namespace frontend\controllers;

use common\models\Carrier;
use common\models\Credential;
use common\models\Entity;
use common\models\UploadPhoto;
use Da\QrCode\QrCode;
use DateTime;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class EntityController extends \yii\web\Controller
{
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

    public function actionDeleteCredential($id,$ueid)
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

        if (count($entity->credentials) < $entity->maxCredentials) {
            $credential = new Credential();
            $credential->idEntity = $entity->id;
            do {
                $credential->ucid = Yii::$app->security->generateRandomString(8);
            } while (!$credential->validate(['ucid']));
            $credential->idEvent = $entity->idEntityType0->idEvent;
            $credential->flagged = 0;
            $credential->blocked = 0;
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $credential->createdAt = $dateTime;
            $credential->updatedAt = $dateTime;
            $credential->createQrCode(150, 5);

            $credential->save();

        }
        return $this->redirect(['view', 'ueid' => $ueid]);
    }
    /**
     * Creates a new Carrier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateCarrier()
    {
        $model = new Carrier();
        $modelUp = new UploadPhoto();

        if ($model->load(Yii::$app->request->post()) && $modelUp->load(Yii::$app->request->post())) {

            $modelUp->photoFile = UploadedFile::getInstance($modelUp,'photoFile');

            if($modelUp->photoFile != null){
                do{
                    $model->photo = Yii::$app->security->generateRandomString(8).'.'.$modelUp->photoFile->extension;
                }while(!$model->validate('photo'));
                $modelUp->upload($model->photo,'carriers');
            }

            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $model->createdAt = $dateTime;
            $model->updatedAt = $dateTime;
            if($model->save()){

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelUp' => $modelUp,
        ]);
    }
}
