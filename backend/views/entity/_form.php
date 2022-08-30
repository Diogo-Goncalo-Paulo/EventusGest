<?php

use common\models\Entitytype;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Entity */
/* @var $entityType common\models\Entitytype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php
    echo $form->field($model, 'idEntityType')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione', 'id' => 'entityType'], 'items' => ArrayHelper::map($entityType,'id','name')]); ?>

    <div class="form-group w-25">
        <label class="control-label" for="q">Quantidade de credenciais a criar</label>
        <?= Html::textInput('q', 0, ['type' => 'number', 'class' => 'form-control', 'id' => 'q']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

