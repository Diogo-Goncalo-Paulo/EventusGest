<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Accesspoint */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pontos de Acesso', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="accesspoint-view">

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
            'name',
            ['label' => 'Evento', 'value' => function ($model) {
                $idArea = $model->getIdAreas($model->id)->one();
                $event = \common\models\Area::find()->select('idEvent')->where(['id' => $idArea])->one();

                return $event['idEvent'];
            }
            ],
            ['label' => 'Área 1', 'value' => function ($model) {
                    $idArea = $model->getIdAreas($model->id)->all();
                    return $idArea[0]["name"];
                }
            ],
            ['label' => 'Área 2', 'value' => function ($model) {
                $idArea = $model->getIdAreas($model->id)->all();
                return $idArea[1]["name"];
            }
            ],
            'createdAt',
            'updatedAt',
        ],
    ]) ?>

</div>
