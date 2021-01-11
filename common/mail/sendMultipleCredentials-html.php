<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $entity common\models\Entity */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $credentials */

?>
<div class="verify-email">
    <p>Olá <?= Html::encode($entity->name) ?>,</p>

    <p>Foram criadas novas credenciais na sua entidade:</p>
    <p>(ver anexos)</p>
</div>

