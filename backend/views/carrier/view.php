<?php

use common\models\Movement;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carrier */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Carregadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row bg-white profile-header">
    <div class="container">
        <div class="media position-relative" style="top:8rem">
            <div class="shadow radius-round border border-white overflow-hidden profile-image" style="background-image: url(<?= Yii::$app->request->baseUrl . '/uploads/carriers/' . ( $model->photo != null ? $model->photo : 'default.png' ) ?>)">
            </div>
            <div class="ml-3 mt-2 media-body">
                <h3 class="mt-3 mb-1"><?= $model->name ?></h3>
                <h6 class="mt-0 text-muted"><?= $model->idCredential0->ucid . ($model->idCredential0->flagged > 0 ? ' <small class="badge badge-warning"><i class="fas fa-flag"></i> ' . $model->idCredential0->flagged . '</small>' : '') . ($model->idCredential0->blocked == 1 ? ' <small class="badge badge-danger"><i class="fas fa-lock"></i> Bloqueada</small>' : '') ?></h6>
            </div>
            <div class="float-right mt-5">
                <?php
                if (Yii::$app->user->can('updateCarrier')) {
                    echo Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Editar', 'class' => 'btn btn-sm btn-action btn-success']) . ' ';
                } else {
                    echo '<a class="btn btn-sm btn-action btn-success disabled" disabled><i class="fa fa-pencil"></i></a> ';
                }
                if (Yii::$app->user->can('deleteCarrier')) {
                    echo Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Apagar', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post']);
                } else {
                    echo '<a class="btn btn-sm btn-action btn-danger disabled" disabled><i class="fas fa-user-lock"></i></a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row carrier-view" style="margin-top: 14rem">
    <div class="col-12 col-sm-4 order-sm-2">
        <div class="shadow-sm list-group mb-3">
            <div class="list-group-item">
                <span class="text-uppercase font-weight-bold mb-0 d-block">Evento</span>
                <?= $model->idCarrierType0->idEvent0->name ?>
            </div>
            <div class="list-group-item">
                <span class="text-uppercase font-weight-bold mb-0 d-block">Área Atual</span>
                <?= (isset($model->idCredential0->idCurrentArea0->name) ? $model->idCredential0->idCurrentArea0->name : 'Não definida') ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-8">
        <div class="shadow-sm card">
            <div class="card-body">
                <div class="form-group">
                    <label class="text-uppercase font-weight-bold mb-0" for="entity">Entidade</label>
                    <div class="input-group">
                        <div class="input-group-prepend d-block">
                            <span class="badge badge-dark mt-1"><?= $model->idCredential0->idEntity0->idEntityType0->name ?></span>
                        </div>
                        <input type="text" class="form-control-plaintext mt-n2 disabled ml-2" disabled id="entity"
                               value="<?= $model->idCredential0->idEntity0->name ?>">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="text-uppercase font-weight-bold mb-0" for="info">Info</label>
                    <input type="text" class="form-control-plaintext mt-n2 disabled" disabled id="info"
                           value="<?= $model->info ?>">
                </div>
            </div>
            <div class="card-footer text-muted">
               <span data-toggle="tooltip" title="Criado a">
                   <?= date_format(date_create($model->createdAt), 'd/m/Y H:i') ?>
               </span>
                <span class="float-right" data-toggle="tooltip" title="Modificado a">
                    <?= date_format(date_create($model->updatedAt), 'd/m/Y H:i') ?>
               </span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card bg-white p-3 mt-3">
            <table class="table table-eg table-hover mb-0">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>De <i class="fas fa-arrow-right"></i> Para</th>
                        <th>Porteiro</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $movements = Movement::find()->where(['idCredential' => $model->idCredential0->id])->all();
                        if ($movements > 0) {
                            foreach ($movements as $movement) {
                                echo '<tr>
                                    <td>' . date_format(date_create($movement['time']), 'd/m/Y H:i') . '</td>
                                    <td>' . $movement['idAreaFrom0']['name'] . ' <i class="fas fa-arrow-right" data-toggle="tooltip" title="' . $movement['idAccessPoint0']['name'] . '"></i> ' . $movement['idAreaTo0']['name'] . '</td>
                                    <td>' . (isset($movement['idUser0']['displayName']) ? $movement['idUser0']['displayName'] : $movement['idUser0']['username']) . '</td>
                                    <td>' . ( Yii::$app->user->can('viewMovement') ? Html::a('<i class="fas fa-eye"></i>', ['movement/view', 'id' => $movement['id']], ['data-toggle' => 'tooltip', 'title' => 'Ver Movimento', 'class' => 'btn btn-sm btn-action btn-primary']) : '<a class="btn btn-sm btn-action btn-primary disabled" disabled><i class="fas fa-eye"></i></a>' ) . '</td>
                                </tr>';
                            }
                        } else {
                            echo '<tr>Sem movimentos</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
