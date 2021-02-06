<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Accesspoint */
/* @var $areas common\models\Area */
/* @var $form yii\widgets\ActiveForm */
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
                    'items' => ArrayHelper::map($areas, 'id', 'name'),
                    'options' => ['class' => 'w-100', 'id' => 'area-1', 'placeholder' => 'Selecione uma área']
                ]); ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group field-user-role">
                <label class="control-label" for="area-2">Área 2</label>
                <?php echo Select2::widget([
                    'name' => 'Accesspoint[area2]',
                    'items' => ArrayHelper::map($areas, 'id', 'name'),
                    'options' => ['class' => 'w-100', 'id' => 'area-2', 'placeholder' => 'Selecione uma área'],
                ]); ?>
                <div class="help-block"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();?>
</div>
<?php
$authKey = Yii::$app->getRequest()->getCookies()->getValue('user-auth');
$url = Yii::$app->getHomeUrl();
$js = <<<JS

const area1 = $("#area-1").change(function (area){
    $.ajax({
        type: "GET",
        url: "$url" + "api/accesspoint/area/" + area.target.value,
        headers: {
            Authorization: 'Basic $authKey'
        },
        success: e => {
            area2.select2("destroy");
            area2.html('');
            area2.select2({data : e.map(arr => {
                return {id : arr.id, text : arr.name}
            })})
        },
        dataType: 'json',
    });
}), area2 = $("#area-2").change(function (area){
    $.ajax({
        type: "GET",
        url: "$url" + "api/accesspoint/area/" + area.target.value,
        headers: {
            Authorization: 'Basic $authKey'
        },
        success: e => {
        },
        dataType: 'json',
    });
});
JS;
$this->registerJs($js);
?>
