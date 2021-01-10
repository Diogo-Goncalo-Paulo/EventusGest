<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $entity common\models\Entity */

?>
Olá <?= $entity->name ?>,
Foi criado um novo link para poder aceder aos seus detalhes e criar novas credenciais.

Link:
http://localhost/eventusgest/frontend/web/entity/view?ueid=<?=$entity->ueid?>

