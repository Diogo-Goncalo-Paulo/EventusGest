<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Credential */

$this->title = $model->ucid;
$this->params['breadcrumbs'][] = ['label' => 'Credenciais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="credential-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= ($model->flagged > 0 ? ' <span class="badge badge-warning" data-toggle="tooltip" title="Marcada"><i class="fas fa-flag"></i> ' . $model->flagged . '</span>' : '') . ($model->blocked > 0 ? ' <span class="badge badge-danger"><i class="fas fa-lock"></i> Bloquada</span>' : '') ?></p>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Re-gerar imagem', ['generate-qrcode', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Tem a certeza que pretende re-gerar a imagem do QR-Code? Esta ação não pode ser desfeita.',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="card shadow-sm mb-3 d-flex flex-row">
        <div class="flex-grow-1">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table mb-0'],
                'attributes' => [
                    [
                        'label' => 'Entidade',
                        'format' => 'raw',
                        'value' => Html::a($model->idEntity0->name, \yii\helpers\Url::toRoute(['/entity/view', 'id' => $model->idEntity0->id])),
                    ],
                    [
                        'label' => 'Area atual',
                        'format' => 'raw',
                        'value' => Html::a($model->idCurrentArea0->name, \yii\helpers\Url::toRoute(['/area/view', 'id' => $model->idCurrentArea0->id])),
                    ],
                    [
                        'label' => 'Evento',
                        'format' => 'raw',
                        'value' => Html::a($model->idEvent0->name, \yii\helpers\Url::toRoute(['/event/view', 'id' => $model->idEvent0->id])),
                    ],
                    'allowedStart',
                    'allowedEnd',
                    'createdAt',
                    'updatedAt',

                ],
            ]) ?>
        </div>
        <div class="">
            <img class="img-responsive" height="343" src="../qrcodes/<?= $model->ucid ?>.png" alt="">
        </div>
    </div>
</div>
