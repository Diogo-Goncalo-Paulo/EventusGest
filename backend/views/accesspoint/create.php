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
    <h4>Não criem pontos de acesso com 2 áreas iguais se não a tabela rebenta.</h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
