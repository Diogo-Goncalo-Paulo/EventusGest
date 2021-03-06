<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carriertype */

$this->title = 'Atualizar Tipo de Portador: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Portador', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carriertype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
