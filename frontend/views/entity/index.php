<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Entity */

$this->title = 'Entidade';
?>
<div class="blank">
    <form action="<?= \yii\helpers\Url::toRoute('view') ?>" method="get">
        <input type="text" name="ueid" class="form-control">
        <button class="btn btn-primary" type="submit">Entrar</button>
    </form>
</div>

