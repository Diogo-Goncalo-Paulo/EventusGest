<?php

use buibr\datepicker\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EventSearch */
/* @var $form yii\widgets\ActiveForm */

$datepickerOptions = [
    'format' => 'DD-MM-YYYY HH:mm:ss',
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
    ]
];
?>

<div class="event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    ?>

    <?php // $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'startDate')->widget(
        DatePicker::className(), [
        'clientOptions' => $datepickerOptions], ['autocomplete' => 'off']);?>

    <?= $form->field($model, 'endDate')->widget(
        DatePicker::className(), [
        'clientOptions' => $datepickerOptions], ['autocomplete' => 'off']);?>

    <?php //$form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updateAt') ?>

    <?php // echo $form->field($model, 'deletedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Procurar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Redefinir', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
