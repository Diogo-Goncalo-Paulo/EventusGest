<?php

use common\models\Entitytype;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EntitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php
    $subquery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
    echo $form->field($model, 'ueid')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\common\models\Entity::find()->andWhere(['deletedAt' => null])->andWhere(['in','idEntityType', $subquery])->all(), 'ueid', 'ueid')]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'weight') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'idEntityType')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\common\models\Entitytype::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->andWhere(['deletedAt' => null])->all(), 'id', 'name')]);?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
