<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Credential */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="credential-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idEntity')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Entity::find()->all(), 'id', 'nome')]); ?>

    <?= $form->field($model, 'idEvent')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Event::find()->all(), 'id', 'name')]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
