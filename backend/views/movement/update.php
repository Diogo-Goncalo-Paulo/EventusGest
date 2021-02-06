<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Movement */
/* @var $credentials common\models\Credential */
/* @var $accessPoint common\models\Accesspoint */
/* @var $areas common\models\Area */

$this->title = 'Atualizar Movimento';
$this->params['breadcrumbs'][] = ['label' => 'Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['type'] = 'update';
?>
<div class="movement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'credentials' => $credentials,
        'accessPoint' => $accessPoint,
        'areas' => $areas,
    ]) ?>

</div>
