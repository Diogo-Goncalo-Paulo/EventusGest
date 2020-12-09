<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carrier */
/* @var $model app\models\UploadPhoto */

$this->title = 'Atualizar Carregadores: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Carregadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUp' => $model,
    ]) ?>

</div>
