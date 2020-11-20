<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MovementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Movimentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movement-index">



    <div class="card bg-transparent border-0 mb-3">
        <div class="card-header bg-transparent border-0 p-0">
            <h1 class="d-inline"><?= Html::encode($this->title) ?></h1>
            <div class="float-right mt-1">
                <a class="btn btn-default radius-round" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseSearch">
                    <i class="fas fa-search"></i>
                </a>
                <?= Html::a('<i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-outline-success radius-round', 'id' => 'btnCreate', 'title' => 'Novo Movimento']) ?>
            </div>
        </div>
        <div class="collapse" id="collapseSearch">
            <div class="card-body">
                <?= $this->render('_search', ['model' => $searchModel]) ?>
            </div>
        </div>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'time',
            [
                'label' => 'Credencial',
                'value' => 'idCredencial0.ucid'
            ],
            [
                'label' => 'Ponto de Acesso',
                'value' => 'idAccessPoint0.nome'
            ],
            [
                'label' => 'De',
                'value' => 'idAreaFrom0.nome'
            ],
            [
                'label' => 'Para',
                'value' => 'idAreaTo0.nome'
            ],
            [
                'label' => 'Porteiro',
                'value' => 'idUser0.username'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
