<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Carrier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo')->fileInput() ?>

    <?= $form->field($model, 'idCredential')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Credential::find()->all(), 'id', 'nome')]); ?>

    <?= $form->field($model, 'idCredential')->textInput() ?>

    <?= $form->field($model, 'idCarrierType')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
