<?php

use buibr\datepicker\DatePicker;
use common\models\Eventuser;
use common\models\User;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Event */
/* @var $form yii\widgets\ActiveForm */

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
    ]
];

?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'startDate')->widget(
                DatePicker::className(), [
                'clientOptions' => $datepickerOptions], ['autocomplete' => 'off']);?>
        </div>
        <div class="col-6">
        <?= $form->field($model, 'endDate')->widget(
            DatePicker::className(), [
            'clientOptions' => $datepickerOptions,
        ], ['autocomplete' => 'off']);?>
        </div>
    </div>

    <div class="form-group field-users">
        <label class="control-label" for="users">Utilizadores com acesso</label>
        <?php
        if (isset($model->id)) {
            $oldEventUsers = ArrayHelper::map(Eventuser::find()->where('idEvent =' . $model->id . '')->all(), 'idUsers', 'idUsers');
        }
        echo Select2::widget([
            'name' => 'Event[users]',
            'items' => ArrayHelper::map(User::find()->all(), 'id', 'username'),
            'options' => ['class' => 'w-100', 'id' => 'event-users','multiple' => true, 'required' => true],
            'value' => isset($oldEventUsers) ? $oldEventUsers : []
        ]);?>
        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
