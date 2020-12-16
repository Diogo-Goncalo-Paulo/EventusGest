<?php

use common\models\Area;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Movement */
/* @var $form yii\widgets\ActiveForm */
JqueryAsset::className();
$subquery = Area::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
?>

<div class="movement-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idCredential')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Credential::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'ucid')]); ?>

    <!--<select name="teste" id="teste">
        <option value="1">Teste</option>
        <option value="2">Teste2</option>
        <option value="3">Teste3</option>
        <option value="4">Teste4</option>
    </select>

    <select name="teste2" id="teste2">
        <option value="1">Teste</option>
        <option value="2">Teste2</option>
        <option value="3">Teste3</option>
        <option value="4">Teste4</option>
    </select>-->

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4 offset-4">
                    <?= $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Accesspoint::find()->where(['id' => Yii::$app->user->identity->getAccessPoint()])->all(), 'id', 'name')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'idAreaFrom')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Area::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name')]); ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'idAreaTo')->widget(Select2::className(), ['items'=>ArrayHelper::map(\common\models\Area::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name')]); ?>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
/*$cena = \yii\helpers\Url::toRoute(['credential/area', 'id' => 1]);;
$script = <<< JS
    $( document ).ready( () => {
        $("#teste").select2().change( () => {
            $.ajax({
                url: '$cena',
                success: (d) => {
                    console.log(d);
                }
            });
           console.log('$cena')
        });
        $("#teste2").select2().change( () => {
           console.log('change2')
        });
        console.log('o paulo é gay')
    });
JS;
$this->registerJs($script);*/
?>