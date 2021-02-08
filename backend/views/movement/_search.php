<?php

use buibr\datepicker\DatePicker;
use common\models\Areaaccesspoint;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MovementSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $credentials common\models\Credential */
/* @var $accessPoint common\models\Accesspoint */
/* @var $areas common\models\Area */
/* @var $users common\models\User */

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

<div class="movement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'time')->widget(DatePicker::className(), [ 'clientOptions' => $datepickerOptions], ['autocomplete' => 'off']);?>

    <?= $form->field($model, 'idCredential')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($credentials, 'id', 'ucid')]); ?>

    <?= $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($accessPoint, 'id', 'name')]);?>

    <?= $form->field($model, 'idAreaFrom')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=> ArrayHelper::map($areas, 'id', 'name'), 'options' => ['placeholder' => 'Selecione']]);?>

    <?= $form->field($model, 'idAreaTo')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($areas, 'id', 'name')]); ?>


    <?= $form->field($model, 'idUser')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($users, 'id', 'displayName')]); ?>

    <div class="form-group">
        <?= Html::submitButton('Procurar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Redefinir', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
