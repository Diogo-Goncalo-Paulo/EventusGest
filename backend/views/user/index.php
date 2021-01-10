<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Utilizadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="card bg-transparent border-0 mb-3">
        <div class="card-header bg-transparent border-0 p-0">
            <h1 class="d-inline"><?= Html::encode($this->title) ?></h1>
            <div class="float-right mt-1">
                <a class="btn btn-default radius-round" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseSearch">
                    <i class="fas fa-search"></i>
                </a>

                <?php //if (Yii::$app->user->can('createMovement')) {
                echo Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-toggle' => 'tooltip', 'class' => 'btn btn-outline-success radius-round', 'id' => 'btnCreate', 'title' => 'Novo Utilizador']);
                //} ?>
            </div>
        </div>
        <div class="collapse" id="collapseSearch">
            <div class="card-body">
                <?= $this->render('_search', ['model' => $searchModel]) ?>
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
                'username',
                'displayName',
                'contact',
                [
                    'label' => 'Estatuto',
                    'value' => 'role0'
                ],
                [
                    'label' => 'Estado',
                    'format' => 'raw',
                    'value' => function ($data) {
                        switch ($data['status']) {
                            case '0':
                                return '<span class="badge badge-danger">Removido</span>';
                                break;
                            case '9':
                                return '<span class="badge badge-warning">Inativo</span>';
                                break;
                            case '10':
                                return '<span class="badge badge-success">Ativo</span>';
                                break;
                            default:
                                return '<span class="badge badge-secondary">Desconhecido</span>';
                        }
                    }
                ],
                [
                    'label' => 'Ponto de Acesso',
                    'value' => 'idAccessPoint0.name'
                ],
                [
                    'label' => 'Evento',
                    'value' => 'currentEvent0.name'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'visible' => (!Yii::$app->user->can('viewUsers') && !Yii::$app->user->can('updateUsers') && !Yii::$app->user->can('deleteUsers') ? false : true),
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            if (Yii::$app->user->can('viewUsers')) {
                                return Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Ver', 'class' => 'btn btn-sm btn-action btn-primary']);
                            } else {
                                return '<a class="btn btn-sm btn-action btn-primary disabled" disabled><i class="fas fa-eye"></i></a>';
                            }
                        },
                        'update' => function ($url, $model, $key) {
                            if ( $model->id == Yii::$app->user->identity->getId() || Yii::$app->user->can('updateUsers')) {
                                return Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id],['data-toggle' => 'tooltip', 'title' => 'Editar', 'class' => 'btn btn-sm btn-action btn-success']);
                            } else {
                                return '<a class="btn btn-sm btn-action btn-success disabled" disabled><i class="fa fa-pencil"></i></a>';
                            }
                        },
                        'delete' => function ($url, $model, $key) {
                            if ( $model->id != Yii::$app->user->identity->getId() && Yii::$app->user->can('deleteUsers')) {
                                return Html::a('<i class="fas fa-user-lock"</i>', ['delete', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Bloquear/Desbloquear', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post']);
                            } else {
                                return '<a class="btn btn-sm btn-action btn-danger disabled" disabled><i class="fas fa-user-lock"></i></a>';
                            }
                        },
                    ]
                ]
            ]
        ]); ?>
    </div>

</div>
