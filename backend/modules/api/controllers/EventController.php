<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class EventController extends ActiveController
{
    public $modelClass = 'common\models\Event';
}
