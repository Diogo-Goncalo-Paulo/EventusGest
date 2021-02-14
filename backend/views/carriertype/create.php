<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carriertype */

$this->title = 'Criar Tipo de Portador';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Portador', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carriertype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
