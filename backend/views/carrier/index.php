<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarrierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrier-index">



    <div class="card bg-transparent border-0 mb-3">
        <div class="card-header bg-transparent border-0 p-0">
            <h1 class="d-inline"><?= Html::encode($this->title) ?></h1>
            <div class="float-right mt-1">
                <a class="btn btn-default radius-round" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseSearch">
                    <i class="fas fa-search"></i>
                </a>

                <?php
                echo Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-toggle' => 'tooltip', 'class' => 'btn btn-outline-success radius-round', 'id' => 'btnCreate', 'title' => 'Novo Portador']);
                //} ?>
            </div>
        </div>
        <div class="collapse" id="collapseSearch">
            <div class="card-body">
                <?= $this->render('_search', ['model' => $searchModel, 'credential' => $credential]) ?>
            </div>
        </div>
    </div>

    <div class="card bg-white p-3 shadow-sm">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}<div class="d-flex"><span class="mr-auto">{summary}</span>{pager}</div>',
            'summary' => 'A mostrar <b>{begin}-{end}</b> de <b>{totalCount}</b>.',

            'tableOptions' => [
                'class'=>'table table-eg table-hover'
            ],
            'columns' => [
                [
                    'label' => 'Nome',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $html = '<div class="d-flex align-items-center">
                                <div class="flex-shrink-0" style="height: 2.5rem; width: 2.5rem">
                                    <img class="radius-round" style="height: 2.5rem; width: 2.5rem" src="'. Yii::$app->request->baseUrl . '/uploads/carriers/' . ( $model->photo != null ? $model->photo : 'default.png' ) . '" alt="Foto">
                                </div>
                                <div class="ml-3">
                                    <div class="font-weight-bold mt-n1">
                                        ' . $model->name . '
                                    </div>
                                    <div class="text-muted mt-n1" style="font-size: 85%">
                                        ' . $model->idCarrierType0->name . '
                                    </div>
                                </div>
                            </div>';
                        return $html;
                    }
                ],
                [
                    'label' => 'Info',
                    'value' => 'info'
                ],
                [
                    'label' => 'Credencial',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->idCredential0->ucid, ['credential/view', 'id' => $model->idCredential0->id], ['data-toggle' => 'tooltip', 'title' => 'Ver Credential', 'class' => 'text-dark']);
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'options' => ['width' => '1'],
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
