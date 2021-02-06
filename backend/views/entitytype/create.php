<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EntityType */
/* @var $areasList common\models\Area */

$this->title = 'Criar Tipo de Entidade';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Entidade', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entity-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'areasList' => $areasList,
    ]) ?>

</div>
