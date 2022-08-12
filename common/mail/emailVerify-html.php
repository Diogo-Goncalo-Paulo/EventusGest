<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Olá <?= Html::encode($user->username) ?>,</p>

    <p>Obrigado por criar conta na EventusGest.</p>

    <p>Use o link abaixo para verificar a sua conta:</p>
    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
