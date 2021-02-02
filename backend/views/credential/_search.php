<?php

use common\models\Entitytype;
use common\models\Eventuser;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CredentialSearch */
/* @var $credentials common\models\Credential */
/* @var $entity common\models\Entity */
/* @var $area common\models\Area */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="credential-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ucid')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($credentials, 'ucid', 'ucid')]); ?>

    <?= $form->field($model, 'idEntity')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($entity, 'id', 'name')]); ?>

    <?= $form->field($model, 'idCurrentArea') ->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items'=>ArrayHelper::map($area, 'id', 'name')]); ?>

    <div class="form-group">
        <?= Html::submitButton('Procurar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Redefinir', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
