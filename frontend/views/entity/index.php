<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Entity */

$this->title = 'Consultar Entidade';
?>
<div class="blank justify-content-center text-center">
    <form action="<?= \yii\helpers\Url::toRoute('view') ?>" method="get">
        <h1 class="d-block my-5"><?= Html::encode($this->title) ?></h1>
        <input type="text" name="ueid" class="form-control mt-5">
        <button class="btn btn-primary btn-block mt-3" type="submit">Consultar</button>
    </form>
</div>

