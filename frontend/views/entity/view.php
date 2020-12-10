<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Entity */

//\yii\helpers\VarDumper::dump( $model , 10, true);

?>

<div class="card mb-5 shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-2 text-center d-flex">
                <i class="fas fa-users fa-4x m-auto"></i>
            </div>
            <div class="col-10">
                <h6>Tipo da entidade</h6>
                <h3 class="mb-0">Nome da entidade</h3>
                <h5 class="font-weight-bold text-black-50 mb-0">dsD4kh78</h5>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3 shadow-sm">
    <div class="card-body p-1">
        <div class="row">
            <div class="col-2">
                <img width="150" height="150" src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1200px-QR_code_for_mobile_English_Wikipedia.svg.png" alt="">
            </div>
            <div class="col-8 p-3">
                <h6 class="mt-3">Credencial</h6>
                <h3 class="mb-0">dsD4kh78</h3>
                <p class="mb-0"><div class="badge badge-warning"><i class="fas fa-flag"></i> 1</div> <div class="badge badge-danger"><i class="fas fa-lock"></i> Bloqueada</div></p>
            </div>
            <div class="col-2">
                <div class="mt-5">
                    <span data-toggle="tooltip" data-boundary="window" title="Carregador">
                        <a class="btn btn-sm btn-action btn-primary" data-toggle="collapse" href="#carrier" role="button" aria-expanded="false" aria-controls="carrier">
                            <i class="fas fa-user"></i>
                        </a>
                    </span>
                        <span data-toggle="tooltip" data-boundary="window" title="Movimentos">
                        <a class="btn btn-sm btn-action btn-primary" data-toggle="collapse" href="#movements" role="button" aria-expanded="false" aria-controls="movements">
                            <i class="fas fa-route"></i>
                        </a>
                    </span>
                    <?= Html::a('<i class="fas fa-ban"></i>', ['delete', 'id' => 1], ['data-toggle' => 'tooltip', 'title' => 'Revogar', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post', 'data-boundary' => "window" ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div id="carrier" class="card-body border-top collapse">
        Carregador
    </div>
    <div id="movements" class="card-body border-top collapse">
        Movimentos
    </div>
</div>

<a class="card card-new text-decoration-none" href="<?= \yii\helpers\Url::to(['addCredential', 'ueic' => 0]) ?>">
    <div class="card-body px-1">
        <div class="row">
            <div class="col-2 text-center d-flex">
                <i class="fas fa-id-card-alt fa-4x m-auto"></i>
            </div>
            <div class="col-10">
                <h6 class="mt-2 mb-0">Credencial</h6>
                <h3 class="mb-0">Adicionar Nova</h3>
            </div>
        </div>
    </div>
</a>