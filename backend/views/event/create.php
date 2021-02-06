<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Event */
/* @var $users common\models\User */

$this->title = 'Criar Evento';
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
    ]) ?>

</div>
