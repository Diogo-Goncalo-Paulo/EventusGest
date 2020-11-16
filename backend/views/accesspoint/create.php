<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Accesspoint */

$this->title = 'Create Accesspoint';
$this->params['breadcrumbs'][] = ['label' => 'Accesspoints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accesspoint-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
