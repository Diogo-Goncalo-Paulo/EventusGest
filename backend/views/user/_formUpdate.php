<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= ($model->id != Yii::$app->user->identity->getId() ? '' : $form->field($model, 'username')->textInput(['autofocus' => true])) ?>

    <?= $form->field($model, 'displayName')->textInput(['required' => true]) ?>

    <?= $form->field($model, 'contact')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>

    <?= $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['items' => ArrayHelper::map(\common\models\Accesspoint::find()->all(), 'id', 'name')]); ?>

    <?= $form->field($model, 'currentEvent')->widget(Select2::className(), ['items' => ArrayHelper::map(\common\models\Event::find()->all(), 'id', 'name')]); ?>

    <div class="form-group field-user-role">
        <label class="control-label" for="user-role">Estatuto</label>
        <?php echo Select2::widget([
            'name' => 'User[role]',
            'value' => (isset($model->role0) ? $model->role0 : ''),
            'items' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'),
            'options' => ['class' => 'w-100', 'id' => 'user-role']
        ]); ?>
        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
