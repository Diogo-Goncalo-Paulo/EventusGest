<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MovementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'time') ?>

    <?= $form->field($model, 'idCredential')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Credential::find()->all(), 'id', 'ucid')]); ?>

    <?= $form->field($model, 'idAccessPoint') ?>

    <?= $form->field($model, 'idAreaFrom') ?>

    <?= $form->field($model, 'idAreaTo') ?>

    <?= $form->field($model, 'idUser') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
