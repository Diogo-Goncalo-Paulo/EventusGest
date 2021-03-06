<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EntityType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Entidade', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="entity-type-view">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <div class="card shadow-sm">
    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table mb-0'],
        'attributes' => [
            'name',
            'qtCredentials',
            [
                'label' => 'Evento',
                'format' => 'raw',
                'value' => Html::a($model->idEvent0->name, \yii\helpers\Url::toRoute(['/event/view', 'id' => $model->idEvent0->id])),
            ],
            [
                'label' => 'Áreas com acesso',
                'value' => function($model){
                    $areas = '';
                    for ($i = 0;$i < count($model->idAreas);$i++){
                        if($i+1 == count($model->idAreas))
                            $areas = $areas.$model->idAreas[$i]->name;
                        else
                            $areas = $areas.$model->idAreas[$i]->name . ' - ';

                    }
                    return $areas;
                }
            ],
            'createdAt',
            'updatedAt'
        ],
    ]) ?>
    </div>

</div>
