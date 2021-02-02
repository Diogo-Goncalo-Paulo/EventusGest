<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Credential */
/* @var $entity common\models\Entity */

$this->title = 'Criar Credencial';
$this->params['breadcrumbs'][] = ['label' => 'Credenciais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="credential-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'entity' => $entity,
    ]) ?>

</div>
