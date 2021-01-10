<?php

use common\models\Areaaccesspoint;
use common\models\Eventuser;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'displayName') ?>

    <?= $form->field($model, 'contact') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'currentEvent')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\common\models\Event::find()->where(['deletedAt' => null])->all(), 'id', 'name')]); ?>

    <?= $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map(\common\models\Accesspoint::find()->andWhere(['deletedAt' => null])->all(), 'id', 'name')]);?>


    <div class="form-group">
        <?= Html::submitButton('Procurar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Redefinir', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
