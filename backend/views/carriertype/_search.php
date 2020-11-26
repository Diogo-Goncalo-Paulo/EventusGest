<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CarriertypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carriertype-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'idEvent')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Event::find()->all(), 'id', 'name')]);?>

    <?php //$form->field($model, 'createdAt') ?>

    <?php //$form->field($model, 'updatedAt') ?>

    <?php //echo $form->field($model, 'deletedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
