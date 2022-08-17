<?php

namespace app\modules\api;

use Yii;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
//        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Max-Age: 999999999');
        header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        //header ("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization, access-control-allow-origin, referrer-policy");
        header ("Access-Control-Allow-Headers: " . Yii::$app->getRequest()->getHeaders()->get('Access-Control-Request-Headers'));
        header('Allow: GET, POST, OPTIONS');

        parent::init();
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
    }
}
