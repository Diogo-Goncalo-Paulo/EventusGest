<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model common\models\Carrier */
/* @var $model common\models\Carrier */
/* @var $modelUp common\models\UploadPhoto */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="carrier-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelUp, 'photoFile')->fileInput() ?>

    <div class="form-group field-credential">
        <label class="control-label" for="credential">Credencial</label>
        <?php

        echo Select2::widget([
            'name' => 'Carrier[idCredential]',
            'items' => ArrayHelper::map($models, 'id', 'ucid'),
            'options' => ['class' => 'w-100', 'id' => 'idCredential', 'required' => true,'placeholder' => 'Selecione'],
            'value' => $credential
        ]);
?>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'idCarrierType')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\common\models\Carriertype::find()->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name')]); ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
