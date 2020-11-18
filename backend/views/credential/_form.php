<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Credential */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="credential-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idEntity')->textInput() ?>

    <?= $form->field($model, 'idEvent')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
