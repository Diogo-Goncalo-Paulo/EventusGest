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

    <?php
    $subquery = Eventuser::find()->select('idEvent')->where(['idUsers' => Yii::$app->user->id]);
    echo $form->field($model, 'currentEvent')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione', 'id' => 'event'], 'items' => ArrayHelper::map(\common\models\Event::find()->where(['deletedAt' => null])->andWhere(['in', 'id', $subquery])->all(), 'id', 'name')]); ?>

    <?php
    $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
    echo $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione', 'id' => 'accessPoint'], 'items' => ArrayHelper::map(\common\models\Accesspoint::find()->where(['deletedAt' => null])->andWhere(['in', 'id', $subquery])->all(), 'id', 'name')]); ?>



    <div class="form-group">
        <?= Html::submitButton('Procurar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Redefinir', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$authKey = Yii::$app->getRequest()->getCookies()->getValue('user-auth');
$url = Yii::$app->getHomeUrl();
$user = Yii::$app->user->identity->username;

$js = <<<JS
const event = $("#event").change(function (event){
    console.log(event);
    
    $.ajax({
        type: "GET",
        url: "$url" + "api/accesspoint/event/" + event.target.value,
        headers: {
            Authorization: 'Basic $authKey'
        },
        success: e => {
            accessPoint.select2("destroy");
            accessPoint.html('');
            accessPoint.select2({data : e.map(arr => {
                return {id : arr.id, text : arr.name}
            })})
        },
        dataType: 'json',
    });
}), accessPoint = $("#accessPoint");
JS;
$this->registerJs($js);
?>
