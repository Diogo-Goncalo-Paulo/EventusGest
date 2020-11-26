<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Movement */

$this->title = $model->idCredential0->ucid . ' para ' . $model->idAreaTo0->name;
$this->params['breadcrumbs'][] = ['label' => 'Movimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="movement-view">
    <h5 class="text-muted text-center"><?= $model->idCredential0->ucid . ( isset($model->idCredential0->idCarrier0->name) ? ' - ' . $model->idCredential0->idCarrier0->name : '' ) ?></h5>
    <h1 class="text-center">
        <?= $model->idAreaFrom0->name . ' <i class="fas fa-arrow-right" data-toggle="tooltip" title="' . $model->idAccessPoint0->name . '"></i> ' . $model->idAreaTo0->name ?>
    </h1>
    <h5 class="text-center">
        <span class="badge badge-success radius-r-0" data-toggle="tooltip" title="<?= date_format(date_create($model->time), 'l jS \of F Y H:i:s') ?>">
            <i class="fas fa-clock"></i> <?= date_format(date_create($model->time), 'd M H:i') ?>
        </span><span class="radius-l-0 badge badge-dark" data-toggle="tooltip" title="Registado por <?= $model->idUser0->username ?>">
            <i class="fas fa-user-astronaut"></i> <?= ( isset( $model->idUser0->displayName ) ? $model->idUser0->displayName :  $model->idUser0->username) ?>
        </span>
    </h5>
    <div class="text-center">
        <?php
            $lastMovement = \app\models\Credential::findOne($model->idCredential)->getMovements()->orderBy(['time'=> SORT_DESC])->one();
            if ($lastMovement['id'] == $model->id) {
                if (Yii::$app->user->can('updateMovement')) {
                    echo Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Editar', 'class' => 'btn btn-sm btn-action btn-success']) . '&nbsp';
                }
                if (Yii::$app->user->can('deleteMovement')) {
                    echo Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Apagar', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post']);
                }
            }
        ?>
    </div>
</div>
