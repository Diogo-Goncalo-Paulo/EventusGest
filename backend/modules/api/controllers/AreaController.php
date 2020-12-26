<?php

namespace app\modules\api\controllers;

use DateTime;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class AreaController extends ActiveController
{
    public $modelClass = 'common\models\Area';

    public function actionDeletearea($id) {
        $model = new $this->modelClass;
        $rec = $model::find()->where(['id' => $id])->one();
        if($rec) {
            $dateTime = new DateTime('now');
            $dateTime = $dateTime->format('Y-m-d H:i:s');
            $rec->deletedAt = $dateTime;
            $rec->save();
            return ['Success' => 'Area deleted successfully!'];
        }
        throw new \yii\web\NotFoundHttpException("Area not found!");
    }
}
