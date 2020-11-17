<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntityTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entity Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entity-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Entity Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'qtCredenciais',
            'idEvent',
            'createdAt',
            //'updatedAt',
            //'deletedAt',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
