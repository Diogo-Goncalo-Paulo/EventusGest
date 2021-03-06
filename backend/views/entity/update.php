<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Entity */
/* @var $entityType common\models\Entitytype */

$this->title = 'Atualizar Entidade: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Entidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'entityType' => $entityType,
    ]) ?>

</div>
