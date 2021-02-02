<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Accesspoint */

$this->title = 'Atualizar Ponto de Acesso: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pontos de Acesso', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="accesspoint-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'areas' => $areas,
    ]) ?>

</div>
