<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CredentialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Credentials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="credential-index">



    <div class="card bg-transparent border-0 mb-3">
        <div class="card-header bg-transparent border-0 p-0">
            <h1 class="d-inline"><?= Html::encode($this->title) ?></h1>
            <div class="float-right mt-1">
                <a class="btn btn-default radius-round" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseSearch">
                    <i class="fas fa-search"></i>
                </a>

                <?php
                echo Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-toggle' => 'tooltip', 'class' => 'btn btn-outline-success radius-round', 'id' => 'btnCreate', 'title' => 'Nova Credencial']);
                //} ?>
            </div>
        </div>
        <div class="collapse" id="collapseSearch">
            <div class="card-body">
                <?= $this->render('_search', ['model' => $searchModel]) ?>
            </div>
        </div>
    </div>

    <div class="card bg-white p-3">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}<div class="d-flex"><span class="mr-auto">{summary}</span>{pager}</div>',
            'summary' => 'A mostrar <b>{begin}-{end}</b> de <b>{totalCount}</b>.',
            'tableOptions' => [
                'class'=>'table table-eg table-hover'
            ],
            'columns' => [
                [
                    'label' => 'UCID',
                    'value' => 'ucid'
                ],
                [
                    'label' => 'Entidade',
                    'value' => 'idEntity0.nome'
                ],
                [
                    'label' => 'Area',
                    'value' => 'idCurrentArea0.nome'
                ],
                [
                    'label' => 'Evento',
                    'value' => 'idEvent0.name'
                ],
                [
                    'label' => 'Carregador',
                    'format' => 'raw',
                    'value' => function($model){
                        $carrier = \app\models\Carrier::find()->where(['idCredential' => $model->id])->one();
                        if($carrier != null){
                            return $carrier->name;
                        }else{
                            return Html::a('<i class="fas fa-user-plus"</i>', ['carrier/create', 'idCredential' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Criar Carregador', 'class' => 'btn btn-sm btn-action btn-primary', 'data-method' => 'post']);
                        }
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Ver', 'class' => 'btn btn-sm btn-action btn-primary']);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id],['data-toggle' => 'tooltip', 'title' => 'Editar', 'class' => 'btn btn-sm btn-action btn-success']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-trash-alt"</i>', ['delete', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Apagar', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post']);

                        },
                    ]
                ]
            ]
        ]); ?>
    </div>
</div>
