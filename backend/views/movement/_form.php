<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Movement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movement-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'idCredencial')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Credential::find()->all(), 'id', 'ucid')]); ?>

    <?= $form->field($model, 'idUser')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username')]); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4 offset-4">
                    <?= $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Accesspoint::find()->all(), 'id', 'nome')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'idAreaFrom')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Area::find()->all(), 'id', 'nome')]); ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'idAreaTo')->widget(Select2::className(), ['items'=>ArrayHelper::map(\app\models\Area::find()->all(), 'id', 'nome')]); ?>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
