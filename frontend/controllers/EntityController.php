<?php

namespace frontend\controllers;

use common\models\Credential;
use common\models\Entity;
use DateTime;
use Yii;
use yii\web\NotFoundHttpException;

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

        if (count($entity->credentials) < $entity->idEntityType0->qtCredentials) {
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

            $credential->save();

        }
        return $this->redirect(['view', 'ueid' => $ueid]);
    }
}
