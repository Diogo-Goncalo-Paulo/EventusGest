<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Movement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movement-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'idCredencial')->textInput() ?>

    <?= $form->field($model, 'idAccessPoint')->textInput() ?>

    <?= $form->field($model, 'idAreaFrom')->textInput() ?>

    <?= $form->field($model, 'idAreaTo')->textInput() ?>

    <?= $form->field($model, 'idUser')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
