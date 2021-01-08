<?php

use buibr\datepicker\DatePicker;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AreaSearch */
/* @var $form yii\widgets\ActiveForm */

$datepickerOptions = [
    'format' => 'HH:mm:ss',
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

<div class="area-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //$form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?php
    $events = \common\models\Eventuser::find()->where(['idUsers' => Yii::$app->user->id])->select('idEvent');
    echo $form->field($model, 'idEvent')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Event::find()->andWhere(['in', 'id', $events])->all(), 'id', 'name')]);?>

    <?= $form->field($model, 'resetTime')->widget(
        DatePicker::className(), [
        'clientOptions' => $datepickerOptions,
    ], ['autocomplete' => 'off']); ?>

    <?php // $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <?php // echo $form->field($model, 'deletedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
