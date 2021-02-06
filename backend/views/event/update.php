<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Event */
/* @var $users common\models\User */
/* @var $eventUsers common\models\Eventuser */

$this->title = 'Atualizar Evento: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'eventUsers' => $eventUsers,
    ]) ?>

</div>
