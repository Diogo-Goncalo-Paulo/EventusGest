<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Movement */

$this->title = 'Criar Movimento';
$this->params['breadcrumbs'][] = ['label' => 'Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['type'] = 'create';
?>
<div class="movement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
