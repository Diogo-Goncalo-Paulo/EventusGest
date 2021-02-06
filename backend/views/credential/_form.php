<?php

use common\models\Entitytype;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Credential */
/* @var $entity common\models\Entity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="credential-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idEntity')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($entity, 'id', 'name')]); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
