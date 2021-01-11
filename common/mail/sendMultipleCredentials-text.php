<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $entity common\models\Entity */
/* @var $credentials */

?>
    Olá <?= Html::encode($entity->name) ?>,
    Foram criadas novas credenciais na sua entidade:
    <?php foreach ($credentials as $credential){
        echo $credential->ucid;
    }?>