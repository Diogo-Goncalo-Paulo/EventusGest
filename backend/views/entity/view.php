<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Entity */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Entidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="entity-view">

    <h1><?= Html::encode($this->title) . ' - <span class="text-muted">' . Html::encode($model->ueid) ?></span></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="card shadow-sm mb-3">
    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table mb-0'],
        'attributes' => [
            [
                'label' => 'Entidade',
                'format' => 'raw',
                'value' => Html::a($model->idEntityType0->name, \yii\helpers\Url::toRoute(['/entitytype/view', 'id' => $model->idEntityType0->id])),
            ],
            'weight',
            [
                'label' => 'Credenciais Maximas',
                'value' => $model->getMaxCredentials(),
            ],
            'createdAt',
            'updatedAt',
        ],
    ]) ?>
    </div>

    <div>
        <?= Html::a('Ver credenciais', ['see-credentials', 'ueid' => $model->ueid], ['class' => 'btn btn-primary']) ?>
    </div>
</div>
