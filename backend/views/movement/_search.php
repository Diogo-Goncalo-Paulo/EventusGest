<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MovementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'time') ?>

    <?= $form->field($model, 'idCredencial') ?>

    <?= $form->field($model, 'idAccessPoint') ?>

    <?= $form->field($model, 'idAreaFrom') ?>

    <?php // echo $form->field($model, 'idAreaTo') ?>

    <?php // echo $form->field($model, 'idUser') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
