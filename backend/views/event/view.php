<?php

use common\models\Eventuser;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Event */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            ['label' => 'Nome da área', 'value' => $model->defaultArea->name],
            ['label' => 'Utilizadores com acesso', 'value' => function($model){
                $users = '';
                for ($i = 0;$i < count($model->users);$i++){
                    if($i+1 == count($model->users))
                        $users = $users.$model->users[$i]->username;
                    else
                        $users = $users.$model->users[$i]->username . ', ';

                }
                return $users;
            }],
            'startDate',
            'endDate',
            'createdAt',
            'updateAt',
        ],
    ]) ?>

</div>
