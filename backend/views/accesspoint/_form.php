<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Accesspoint */
/* @var $form yii\widgets\ActiveForm */

/*$js = <<< JS
$(document).change(() => { 
    $('#area-1').click(() => {
        var selectedArea = $(this).children('option:selected').val();
        $('#area-2 option[value="' + selectedArea + '"]').remove();
    });
}); 
JS;
$this->registerJs($js);*/
?>

<div class="accesspoint-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])?>

    <div class="row">
        <div class="col-6">
            <div class="form-group field-user-role">
                <label class="control-label" for="area-1">Área 1</label>
                <?php echo Select2::widget([
                    'name' => 'Accesspoint[area1]',
                    'items' => ArrayHelper::map(\common\models\Area::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name'),
                    'options' => ['class' => 'w-100', 'id' => 'area-1']
                ]); ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group field-user-role">
                <label class="control-label" for="area-2">Área 2</label>
                <?php echo Select2::widget([
                    'name' => 'Accesspoint[area2]',
                    'items' => ArrayHelper::map(\common\models\Area::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name'),
                    'options' => ['class' => 'w-100', 'id' => 'area-2'],
                ]); ?>
                <div class="help-block"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();?>
</div>
