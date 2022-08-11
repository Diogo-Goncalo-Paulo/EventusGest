<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $entityType common\models\Entitytype */
/* @var $entity common\models\Entity */

$this->title = 'Entidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entity-index">
    <div class="card bg-transparent border-0 mb-3">
        <div class="card-header bg-transparent border-0 p-0">
            <h1 class="d-inline"><?= Html::encode($this->title) ?></h1>
            <div class="float-right mt-1">
                <a class="btn btn-default radius-round" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseSearch">
                    <i class="fas fa-search"></i>
                </a>

                <?php
                echo Html::a('<i class="fas fa-download"></i>', ['download-all-credentials'], ['data-toggle' => 'tooltip', 'class' => 'btn btn-outline-success radius-round', 'id' => 'btnExport', 'title' => 'Exportar todas as credenciais']);
                if (Yii::$app->user->can('createEntity')) {
                    echo Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-toggle' => 'tooltip', 'class' => 'btn btn-outline-success radius-round', 'id' => 'btnCreate', 'title' => 'Nova Entidade']);
                }
                ?>
            </div>
        </div>
        <div class="collapse" id="collapseSearch">
            <div class="card-body">
                <?= $this->render('_search', ['model' => $searchModel, 'entity' => $entity, 'entityType' => $entityType]) ?>
            </div>
        </div>
    </div>

    <div class="card bg-white p-3 shadow-sm">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}<div class="d-flex"><span class="mr-auto">{summary}</span>{pager}</div>',
            'summary' => 'A mostrar <b>{begin}-{end}</b> de <b>{totalCount}</b>.',
            'tableOptions' => [
                'class' => 'table table-eg table-hover'
            ],
            'columns' => [
                [
                    'label' => 'UEID',
                    'value' => 'ueid',
                ],
                [
                    'label' => 'Nome',
                    'value' => 'name',
                ],
                [
                    'label' => 'Email',
                    'value' => 'email',
                ],
                [
                    'label' => 'Tipo de Entidade',
                    'value' => 'idEntityType0.name',
                ],
                [
                    'label' => 'Peso',
                    'value' => 'weight',
                ],
                [
                    'label' => 'Credenciais Maximas',
                    'value' => 'maxCredentials',
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Ver', 'class' => 'btn btn-sm btn-action btn-primary']);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Editar', 'class' => 'btn btn-sm btn-action btn-success']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-trash-alt"</i>', ['delete', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Apagar', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post']);

                        },
                    ],
                ],

            ],
        ]); ?>
    </div>
</div>
