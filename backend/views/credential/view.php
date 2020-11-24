<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Credential */

$this->title = $model->ucid;
$this->params['breadcrumbs'][] = ['label' => 'Credentials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="credential-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ucid',
            [
                'label' => 'Entidade',
                'value' => $model->idEntity0->nome,
            ],
            [
                'label' => 'Area atual',
                'value' => function($model){
                    if($model->idCurrentArea != null){
                        return $model->idCurrentArea0->nome;
                    }
                },
            ],
            [
                'label' => 'Evento',
                'value' => $model->idEvent0->name,
            ],
            'flagged',
            [
                'label' => 'Bloqueado',
                'format' => 'raw',
                'value' => function($model){
                    if($model->blocked == 0)
                        return '<span class="badge badge-success">No</span>';
                    else
                        return '<span class="badge badge-danger">Yes</span>';
                },
            ],
            'createdAt',
            'updatedAt',
        ],
    ]) ?>

</div>
