<?php

use common\models\Event;
use common\models\User;
use Da\QrCode\Contracts\ErrorCorrectionLevelInterface;
use Da\QrCode\Label;
use yii\helpers\Html;
use yii\grid\GridView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CredentialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $credentials common\models\Credential */
/* @var $entity common\models\Entity */
/* @var $area common\models\Area */

$this->title = 'Credenciais';
$this->params['breadcrumbs'][] = $this->title;

$sendEmails = Event::findOne(Yii::$app->user->identity->getEvent())->sendEmails;

?>
<div class="credential-index">


    <div class="card bg-transparent border-0 mb-3">
        <div class="card-header bg-transparent border-0 p-0">
            <h1 class="d-inline"><?= Html::encode($this->title) ?></h1>
            <div class="float-right mt-1">
                <a class="btn btn-default radius-round" data-toggle="collapse" href="#collapseSearch" role="button"
                   aria-expanded="false" aria-controls="collapseSearch">
                    <i class="fas fa-search"></i>
                </a>
                <?php
                    if (Yii::$app->user->can('sendEmails') && $sendEmails == true) {
                        echo Html::a('<i class="fas fa-inbox"></i>', ['email-all-entities-credentials'], ['data-toggle' => 'tooltip', 'class' => 'btn btn-outline-success radius-round', 'id' => 'btnCreate', 'title' => 'Enviar email com todas as credenciais de cada entidade']);
                    }
                ?>
                <?= Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-toggle' => 'tooltip', 'class' => 'btn btn-outline-success radius-round', 'id' => 'btnCreate', 'title' => 'Nova Credencial']); ?>
            </div>
        </div>
        <div class="collapse" id="collapseSearch">
            <div class="card-body">
                <?= $this->render('_search', ['model' => $searchModel, 'credentials' => $credentials, 'entity' => $entity, 'area' => $area,]) ?>
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
                    'label' => 'UCID',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->ucid . ( $model->flagged > 0 ? ' <span class="badge badge-warning"><i class="fas fa-flag"></i> ' . $model->flagged . '</span>' : '' ) . ( $model->blocked > 0 ? ' <span class="badge badge-danger"><i class="fas fa-lock"></i> Bloquada</span>' : '' );
                    }
                ],
                [
                    'label' => 'Entidade',
                    'value' => 'idEntity0.name'
                ],
                [
                    'label' => 'Area',
                    'value' => 'idCurrentArea0.name'
                ],
                [
                    'label' => 'Portador',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->idCarrier0 != null) {
                            return Html::a($model->idCarrier0->name, ['carrier/view', 'id' => $model->idCarrier0->id], ['data-toggle' => 'tooltip', 'title' => 'Ver Portador']);
                        } else {
                            return Html::a('<i class="fas fa-user-plus"</i>', ['carrier/create', 'idCredential' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Adicionar Portador', 'class' => 'btn btn-sm btn-action btn-primary', 'data-method' => 'post']);
                        }
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {flag} {block} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Ver', 'class' => 'btn btn-sm btn-action btn-primary']);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Editar', 'class' => 'btn btn-sm btn-action btn-success']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Apagar', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post']);
                        },
                        'flag' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-flag"></i>', ['flag', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Marcar', 'class' => 'btn btn-sm btn-action btn-warning', 'data-method' => 'post']);
                        },
                        'block' => function ($url, $model, $key) {
                            if ($model->blocked) {
                                return Html::a('<i class="fas fa-unlock"></i>', ['block', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Desbloquear', 'class' => 'btn btn-sm btn-action btn-warning', 'data-method' => 'post']);
                            } else {
                                return Html::a('<i class="fas fa-lock"></i>', ['block', 'id' => $model->id], ['data-toggle' => 'tooltip', 'title' => 'Bloquear', 'class' => 'btn btn-sm btn-action btn-danger', 'data-method' => 'post']);
                            }
                        },
                    ]
                ]
            ]
        ]);
        ?>
    </div>
</div>
