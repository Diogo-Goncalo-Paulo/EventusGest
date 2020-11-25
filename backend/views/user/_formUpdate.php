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

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'displayName')->textInput() ?>

    <?= $form->field($model, 'contact')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>

    <?= $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Accesspoint::find()->all(), 'id', 'nome')]); ?>

    <?= $form->field($model, 'currentEvent')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Event::find()->all(), 'id', 'name')]); ?>

    <?php

    $roles = Yii::$app->authManager->getRoles();
    $rolesArray = [];
    foreach ($roles as $role) {
        array_push($rolesArray, $role->name);
    }

    echo Select2::widget([
        'name' => 'User[role]',
        'value' => $model->role0,
        'items' => $rolesArray,
    ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
