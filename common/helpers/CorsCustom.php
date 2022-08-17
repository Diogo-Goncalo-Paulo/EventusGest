<?php

namespace common\helpers;

use Yii;
use yii\base\ExitException;

class CorsCustom extends \yii\filters\Cors
{
    /**
     * @throws ExitException
     */
    public function beforeAction($action): bool
    {
        parent::beforeAction($action);
        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST, GET, PUT, DELETE');
        }
        return true;

    }

}