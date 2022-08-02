<?php

use buibr\datepicker\DatePicker;
use common\models\Entitytype;
use common\models\User;
use common\models\Event;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Credential */
/* @var $entity common\models\Entity */
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

<div class="credential-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idEntity')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($entity, 'id', 'name')]); ?>

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
                'options' => ['id' => 'allowedEnd'],
                'clientOptions' => $datepickerOptions,
            ], ['autocomplete' => 'off']);?>
        </div>
    </div>

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