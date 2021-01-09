<?php

use common\models\Entitytype;
use common\models\Eventuser;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CredentialSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="credential-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ucid')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Credential::find()->andWhere(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'ucid')]); ?>

    <?php
    $subquery = Entitytype::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
    echo $form->field($model, 'idEntity')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Entity::find()->where(['deletedAt' => null])->andWhere(['in','idEntityType', $subquery])->all(), 'id', 'name')]); ?>

    <?= $form->field($model, 'idCurrentArea') ->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Area::find()->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name')]); ?>

    <?php // echo $form->field($model, 'flagged') ?>

    <?php // echo $form->field($model, 'blocked') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <?php // echo $form->field($model, 'deletedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
