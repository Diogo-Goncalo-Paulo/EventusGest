<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Accesspoint */

$this->title = 'Criar Ponto de Acesso';
$this->params['breadcrumbs'][] = ['label' => 'Pontos de Acesso', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accesspoint-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'areas' => $areas,
    ]) ?>

</div>
