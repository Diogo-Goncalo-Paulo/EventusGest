<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carriertype */

$this->title = 'Create Carriertype';
$this->params['breadcrumbs'][] = ['label' => 'Carriertypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carriertype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
