<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EntityType */
/* @var $areas common\models\Entitytypeareas */
/* @var $areasList common\models\Area */

$this->title = 'Atualizar Tipo de Entidade: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Entidade', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entity-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'areas' => $areas,
        'areasList' => $areasList,
    ]) ?>

</div>
