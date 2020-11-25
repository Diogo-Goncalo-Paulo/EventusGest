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

    <?php
    $subquery = \app\models\Carrier::find()->select('idCredential');
    $query = \app\models\Credential::find()->where(['not in','id' , $subquery]);
    $models = $query->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();


    echo $form->field($model, 'idCredential')->widget(Select2::className(), ['items'=>ArrayHelper::map($models, 'id', 'ucid')]); ?>

    <?= $form->field($model, 'idCarrierType')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Carriertype::find()->where(['deletedAt' => null])->all(), 'id', 'nome')]); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
