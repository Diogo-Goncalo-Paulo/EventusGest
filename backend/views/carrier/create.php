<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carrier */
/* @var $modelUp app\models\UploadPhoto */

$this->title = 'Criar Portador';
$this->params['breadcrumbs'][] = ['label' => 'Portadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$subquery = \common\models\Carrier::find()->select('idCredential');
$query = \common\models\Credential::find()->where(['not in','id' , $subquery]);
$models = $query->where(['deletedAt' => null])->andWhere(['idEvent' => Yii::$app->user->identity->getEvent()])->all();

$idCredential = Yii::$app->request->get('idCredential');

if(isset($idCredential)){
    $credential = \common\models\Credential::findOne($idCredential);
}
?>
<div class="carrier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUp' => $modelUp,
        'models' => $models,
        'credential' => isset($idCredential) ? $credential : 0,
    ]) ?>

</div>
