<?php

use common\models\Entitytype;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntitySearch */
/* @var $entity common\models\Entity */
/* @var $entityType common\models\Entitytype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php

    echo $form->field($model, 'ueid')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($entity, 'ueid', 'ueid')]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'weight') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'idEntityType')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($entityType, 'id', 'name')]);?>

    <div class="form-group">
        <?= Html::submitButton('Procurar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Redefinir', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
