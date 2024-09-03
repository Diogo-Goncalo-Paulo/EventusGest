<?php

use common\models\Entitytype;
use common\models\Event;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use buibr\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Entity */
/* @var $entityType common\models\Entitytype */
/* @var $form yii\widgets\ActiveForm */

$id = Yii::$app->user->identity->getEvent();
$currentEvent = Event::findOne($id);

$datepickerOptions = [
    'format' => 'YYYY-MM-DD HH:mm:ss',
    'locale' => 'pt',
    'icons' => [
        'time' => 'fas fa-time',
        'date' => 'fas fa-calendar',
        'up' => 'fas fa-chevron-up',
        'down' => 'fas fa-chevron-down',
        'previous' => 'fas fa-chevron-left',
        'next' => 'fas fa-chevron-right',
        'today' => 'fas fa-calendar-day',
        'clear' => 'fas fa-trash',
        'close' => 'fas fa-remove'
    ],
    'minDate' => $currentEvent->startDate,
    'maxDate' => $currentEvent->endDate
];
?>

<div class="entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true, 'value' => 1]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'value' => 'email@email.pt']) ?>

    <?php
    echo $form->field($model, 'idEntityType')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione', 'id' => 'entityType'], 'items' => ArrayHelper::map($entityType,'id','name')]); ?>

    <div class="form-group w-25">
        <label class="control-label" for="q">Quantidade de credenciais a criar</label>
        <?= Html::textInput('q', 0, ['type' => 'number', 'class' => 'form-control', 'id' => 'q']) ?>
    </div>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'allowedStart')->widget(
                DatePicker::className(), [
                'options' => ['id' => 'allowedStart', 'value' => $currentEvent->startDate],
                'clientOptions' => $datepickerOptions,
                'clientEvents' => [
                    'dp.change' => new \yii\web\JsExpression ( "function (e) { handleChange(e) }" ),
                ],],
                ['autocomplete' => 'off']);?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'allowedEnd')->widget(
                DatePicker::className(), [
                'options' => ['id' => 'allowedEnd', 'value' => $currentEvent->endDate],
                'clientOptions' => $datepickerOptions,
            ], ['autocomplete' => 'off']);?>
        </div>
    </div>

    <div class="mt-2 mb-2">
        <?= $form->field($model, 'printCarrier')->checkbox() ?>
    </div

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
    function handleChange (e) {
        $('#allowedEnd').parent().datetimepicker('options', {'minDate': e.date._d}).datetimepicker("date", e.date._d);
    }
</script>