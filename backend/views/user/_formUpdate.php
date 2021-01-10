<?php

use common\models\Areaaccesspoint;
use common\models\Eventuser;
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

    <?= ($model->id != Yii::$app->user->identity->getId() ? '' : $form->field($model, 'username')->textInput(['autofocus' => true])) ?>

    <?= $form->field($model, 'displayName')->textInput(['required' => true]) ?>

    <?= $form->field($model, 'contact')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>

    <?php
    $subquery = Areaaccesspoint::find()->select('idAccessPoint')->join('INNER JOIN', 'areas', 'idArea = id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);
    echo $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione', 'id' => 'accessPoint'], 'items' => ArrayHelper::map(\common\models\Accesspoint::find()->Where(['in', 'id', $subquery])->all(), 'id', 'name')]); ?>

    <?php
    $subquery = Eventuser::find()->select('idEvent')->where(['idUsers' => Yii::$app->user->id]);
    echo $form->field($model, 'currentEvent')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione', 'id' => 'event'], 'items' => ArrayHelper::map(\common\models\Event::find()->where(['in', 'id', $subquery])->all(), 'id', 'name')]); ?>

    <div class="form-group field-user-role">
        <label class="control-label" for="user-role">Estatuto</label>
        <?php echo Select2::widget([
            'name' => 'User[role]',
            'value' => (isset($model->role0) ? $model->role0 : ''),
            'items' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'),
            'options' => ['class' => 'w-100', 'id' => 'user-role']
        ]); ?>
        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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
