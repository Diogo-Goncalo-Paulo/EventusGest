<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carrier */
/* @var $modelUp app\models\UploadPhoto */

$this->title = 'Atualizar Portadores: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Portadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUp' => $modelUp,
        'models' => $models,
        'credential' => $credential,
    ]) ?>

</div>
