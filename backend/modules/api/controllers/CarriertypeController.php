<?php

namespace app\modules\api\controllers;

use DateTime;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class CarriertypeController extends ActiveController
{
    public $modelClass = 'common\models\Carriertype';

    public function actionDeletecarriertype($id) {
        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id])->one();
        if($rec) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $rec->deletedAt = $dateTime;
            $rec->save();
            return ['Success' => 'Carrier type deleted successfully!'];
        }
        throw new \yii\web\NotFoundHttpException("Carrier type not found!");
    }
}
