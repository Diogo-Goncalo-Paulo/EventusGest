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

                <?php //if (Yii::$app->user->can('createMovement')) {
                    echo Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-toggle' => 'tooltip', 'class' => 'btn btn-outline-success radius-round', 'id' => 'btnCreate', 'title' => 'Novo Movimento']);
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
                    'label' => 'Data',
                    'value' => 'time',
                    'format' => ['date', 'php:d-m-Y H:i']
                ],
                [
                    'label' => 'Credencial',
                    'value' => 'idCredential0.ucid'
                ],
                [
                    'label' => 'Ponto de Acesso',
                    'value' => 'idAccessPoint0.name'
                ],
                [
                    'label' => 'De',
                    'value' => 'idAreaFrom0.name'
                ],
                [
                    'label' => 'Para',
                    'value' => 'idAreaTo0.name'
                ],
                [
                    'label' => 'Porteiro',
                    'value' => 'idUser0.username'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    //'visible' => (!Yii::$app->user->can('viewMovement') && !Yii::$app->user->can('updateMovement') && !Yii::$app->user->can('deleteMovement') ? false : true),
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            if (Yii::$app->user->can('viewMovement')) {
                                return Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Ver', 'class' => 'btn btn-sm btn-action btn-primary']);
                            } else {
                                return '<a class="btn btn-sm btn-action btn-primary disabled" disabled><i class="fas fa-eye"></i></a>';
                            }
                        },
                        'update' => function ($url, $model, $key) {
                            $lastMovement = \app\models\Credential::findOne($model->idCredential)->getMovements()->orderBy(['time'=> SORT_DESC])->one();
                            if ($lastMovement['id'] == $model->id && Yii::$app->user->can('updateMovement')) {
                                return Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id],['data-toggle' => 'tooltip', 'title' => 'Editar', 'class' => 'btn btn-sm btn-action btn-success']);
                            } else {
                                return '<a class="btn btn-sm btn-action btn-success disabled" disabled><i class="fa fa-pencil"></i></a>';
                            }
                        },
                        'delete' => function ($url, $model, $key) {
                            $lastMovement = \app\models\Credential::findOne($model->idCredential)->getMovements()->orderBy(['time'=> SORT_DESC])->one();
                            if ($lastMovement['id'] == $model->id && Yii::$app->user->can('deleteMovement')) {
                                return Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Apagar', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post']);
                            } else {
                                return '<a class="btn btn-sm btn-action btn-danger disabled" disabled><i class="fas fa-trash-alt"></i></a>';
                            }
                        },
                    ]
                ]
            ]
        ]); ?>
    </div>

</div>
