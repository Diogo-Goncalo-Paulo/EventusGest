<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Movement */
/* @var $credentials common\models\Credential */
/* @var $accessPoint common\models\Accesspoint */
/* @var $areas common\models\Area */

$this->title = 'Criar Movimento';
$this->params['breadcrumbs'][] = ['label' => 'Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['type'] = 'create';
?>
<div class="movement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'credentials' => $credentials,
        'accessPoint' => $accessPoint,
        'areas' => $areas,
    ]) ?>

</div>
