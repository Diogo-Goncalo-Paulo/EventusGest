<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carrier */
/* @var $modelUp app\models\UploadPhoto */

$this->title = 'Criar Carregador';
$this->params['breadcrumbs'][] = ['label' => 'Carregadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUp' => $modelUp,
    ]) ?>

</div>
