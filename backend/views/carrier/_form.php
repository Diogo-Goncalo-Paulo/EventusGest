<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model app\models\Carrier */
/* @var $modelUp app\models\UploadPhoto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrier-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelUp, 'photoFile')->fileInput() ?>

    <?php
    $subquery = \common\models\Carrier::find()->select('idCredential');
    $query = \common\models\Credential::find()->where(['not in','id' , $subquery]);
    $models = $query->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();

    echo $form->field($model, 'idCredential')->widget(Select2::className(), ['items'=>ArrayHelper::map($models, 'id', 'ucid')]); ?>

    <?= $form->field($model, 'idCarrierType')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Carriertype::find()->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name')]); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
