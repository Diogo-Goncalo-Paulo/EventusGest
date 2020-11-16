<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CredentialSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="credential-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ucid') ?>

    <?= $form->field($model, 'idEntity') ?>

    <?= $form->field($model, 'idCurrentArea') ?>

    <?= $form->field($model, 'idEvent') ?>

    <?php // echo $form->field($model, 'flagged') ?>

    <?php // echo $form->field($model, 'blocked') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <?php // echo $form->field($model, 'deletedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
