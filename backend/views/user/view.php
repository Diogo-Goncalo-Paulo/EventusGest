<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>
<div class="row bg-white profile-header">
    <div class="container">
        <div class="media position-relative" style="top:8rem">
            <div class="shadow radius-round border border-white overflow-hidden profile-image">
            </div>
            <div class="ml-3 mt-2 media-body">
                <h3 class="mt-3 mb-1" data-placement="left" data-toggle="tooltip" title="<?= $model->role0 ?>"><?= ( isset($model->displayName) ? $model->displayName : $model->username) ?></h3>
                <h6 class="mt-0 text-muted"><?= $model->username ?> <?= ( $model->status != 10 ? ($model->status == 9 ? '<small class="badge badge-warning">Inativo</small>' : '<small class="badge badge-danger">Removido</small>' ) : '') ?></h6>
            </div>
            <div class="float-right mt-5">
                <?php
                    if ( $model->id == Yii::$app->user->identity->getId() || Yii::$app->user->can('updateUsers')) {
                        echo Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id],['data-toggle' => 'tooltip', 'title' => 'Editar', 'class' => 'btn btn-sm btn-action btn-success']) . ' ';
                    } else {
                        echo '<a class="btn btn-sm btn-action btn-success disabled" disabled><i class="fa fa-pencil"></i></a> ';
                    }
                    if ( $model->id != Yii::$app->user->identity->getId() && Yii::$app->user->can('deleteUsers')) {
                        echo Html::a('<i class="fas fa-user-lock"></i>', ['delete', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Bloquear/Desbloquear', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post']);
                    } else {
                        echo '<a class="btn btn-sm btn-action btn-danger disabled" disabled><i class="fas fa-user-lock"></i></a>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row user-view" style="margin-top: 14rem">
    <div class="col-12 col-sm-4 order-sm-2">
        <div class="shadow-sm list-group mb-3">
            <div class="list-group-item">
                <span class="text-uppercase font-weight-bold mb-0 d-block">Evento Atual</span>
                <?= ( isset($model->currentEvent0) ? $model->currentEvent0->name : 'Não definido' ) ?>
            </div>
            <div class="list-group-item">
                <span class="text-uppercase font-weight-bold mb-0 d-block">Ponto de acesso Atual</span>
                <?= ( isset($model->idAccessPoint0) ? $model->idAccessPoint0->nome : 'Não definido' ) ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-8">
        <div class="shadow-sm card">
            <div class="card-body">
                <div class="form-group">
                    <label class="text-uppercase font-weight-bold mb-0" for="email">Email</label>
                    <input type="email" class="form-control-plaintext mt-n2 disabled" disabled id="email" value="<?= $model->email ?>">
                </div>
                <div class="form-group mb-0">
                    <label class="text-uppercase font-weight-bold mb-0" for="contact">Contacto</label>
                    <input type="email" class="form-control-plaintext mt-n2 disabled" disabled id="contact" value="<?= $model->contact ?>">
                </div>
            </div>
            <div class="card-footer text-muted">
               <span data-toggle="tooltip" title="Criado a">
                    <?= date('d/m/Y H:i', $model->created_at) ?>
               </span>
                <span class="float-right" data-toggle="tooltip" title="Modificado a">
                    <?= date('d/m/Y H:i', $model->updated_at) ?>
               </span>
            </div>
        </div>
    </div>
</div>
