<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Accesspoint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accesspoint-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true])?>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'id')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Area::find()->all(), 'id', 'nome')]);?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'id')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Area::find()->all(), 'id', 'nome')]);?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
