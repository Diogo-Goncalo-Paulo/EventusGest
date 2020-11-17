<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MovementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Movements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movement-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Movement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'time',
            'idCredencial',
            'idAccessPoint',
            'idAreaFrom',
            //'idAreaTo',
            //'idUser',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
