<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Carriertype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carriertype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'idEvent')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\app\models\Event::find()->all(), 'id', 'name')]);?>

    <div class="mt-2 mb-2">
        <?= $form->field($model, 'isCar')->checkbox() ?>
    </div

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
