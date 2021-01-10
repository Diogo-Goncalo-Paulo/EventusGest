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

    <?= $form->field($model, 'time')->widget(
        DatePicker::className(), [
        'clientOptions' => $datepickerOptions], ['autocomplete' => 'off']);?>

    <?= $form->field($model, 'idCredential')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\common\models\Credential::find()->andWhere(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'ucid')]); ?>

    <?php
    $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
    echo $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\common\models\Accesspoint::find()->andWhere(['deletedAt' => null])->andWhere(['in', 'id', $subquery])->all(), 'id', 'name')]);?>

    <?= $form->field($model, 'idAreaFrom')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=> ArrayHelper::map(\common\models\Area::find()->andWhere(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name'), 'options' => ['placeholder' => 'Selecione']]);?>

    <?= $form->field($model, 'idAreaTo')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\common\models\Area::find()->andWhere(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name')]); ?>


    <?= $form->field($model, 'idUser')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\common\models\User::find()->all(), 'id', 'displayName')]); ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
