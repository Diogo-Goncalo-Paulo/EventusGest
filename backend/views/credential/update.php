<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Credential */
/* @var $entity common\models\Entity */

$this->title = 'Atualizar Credencial: ' . $model->ucid;
$this->params['breadcrumbs'][] = ['label' => 'Credenciais', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ucid, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="credential-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'entity' => $entity,
    ]) ?>

</div>
