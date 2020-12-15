<?php

use common\models\Entitytype;
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

    <?php
    $subquery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
    echo $form->field($model, 'idEntity')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Entity::find()->where(['deletedAt' => null])->andWhere(['in','idEntityType',$subquery])->all(), 'id', 'name')]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
