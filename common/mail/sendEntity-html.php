<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $entity common\models\Entity */

?>
<div class="verify-email">
    <p>Olá <?= Html::encode($entity->name) ?>,</p>
    <p>Foi criado um novo link para poder aceder aos seus detalhes e criar novas credenciais.</p>
    <p>Link:</p>
    <a href="http://localhost/eventusgest/frontend/web/entity/view?ueid=<?=Html::encode($entity->ueid)?>">http://localhost/eventusgest/frontend/web/entity/view?ueid=<?=Html::encode($entity->ueid)?></a>
</div>

