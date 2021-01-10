<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Eventus Gest</h1>

        <p class="lead">O EventusGest é um software de gestão de credenciais de eventos.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php
            if (!Yii::$app->user->isGuest) {
                echo '<div class="col-lg-6">
                    <h2>Entidades</h2>
                    <p>Você é uma entidade e vai participar em um dos nossos eventos, consulte e faça gestão das suas credenciais.</p>
                    <p><a class="btn btn-default" href="' . Url::toRoute("entity / index") . '">Consultar »</a></p>
                </div>
                <div class="col-lg-6">
                    <h2>Backoffice</h2>    
                    <p>Se é um utilizador faça toda a gestão dos eventos, áreas, pontos de acesso, movimentos, credenciais, entidades, tipos de entidades, carregadores, tipos de carregadores a partir do backoffice.</p>
                    <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Consultar &raquo;</a></p>
                </div>';
            } else {
                echo '<div class="col-lg-12">
                    <h2>Entidades</h2>
                    <p>Você é uma entidade e vai participar em um dos nossos eventos, consulte e faça gestão das suas credenciais.</p>
                    <p><a class="btn btn-default" href="' . Url::toRoute("entity / index") . '">Consultar »</a></p>
                </div>';
            }
            ?>


        </div>
    </div>
</div>
