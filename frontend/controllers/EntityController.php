<?php

namespace frontend\controllers;

use common\models\Entity;
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

}
