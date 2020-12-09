<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntityType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qtCredentials')->textInput() ?>

    <div class="form-group field-user-role">
        <label class="control-label" for="user-role">Areas</label>
        <?php echo Select2::widget([
            'name' => 'Entitytype[areas]',
            'items' => ArrayHelper::map(\app\models\Area::find()->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name'),
            'options' => ['class' => 'w-100', 'id' => 'entitytype-areas','multiple' => true]
        ]); ?>
        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
