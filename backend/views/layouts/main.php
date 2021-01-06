<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use common\models\User;
use pcrt\widgets\select2\Select2;
use yii\bootstrap4\Dropdown;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

$js = <<<SCRIPT
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
    $("[data-toggle='popover']").popover(); 
});
SCRIPT;
$this->registerJs($js);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Yii::$app->name . ' - ' . Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="https://kit.fontawesome.com/d7254eeaba.js" crossorigin="anonymous"></script>
</head>
<body class="row m-0">
<?php $this->beginBody() ?>

<aside class="col p-0 bg-dark colllapse collapse-sideways show" id="sidebar">
    <div class="sidebar-brand">
        <?= Html::a('<i class="fas fa-id-card-alt"></i> EventusGest', Yii::$app->homeUrl) ?>
    </div>
    <ul class="nav sidebar">
        <?php
        $pages = [
            ['title' => 'Eventos',                  'url' => './event',         'icon' => 'fas fa-calendar',        'permition' => 'viewEvent'],
            ['title' => 'Áreas',                    'url' => './area',          'icon' => 'fas fa-map',             'permition' => 'viewArea'],
            ['title' => 'Pontos de Acesso',         'url' => './accesspoint',   'icon' => 'fas fa-door-open',       'permition' => 'viewAccesspoint'],
            ['title' => 'Movimentos',               'url' => './movement',      'icon' => 'fas fa-route',           'permition' => 'viewMovement'],
            ['title' => 'Credenciais',              'url' => './credential',    'icon' => 'fas fa-id-card-alt',     'permition' => 'viewCredential'],
            ['title' => 'Entidades',                'url' => './entity',        'icon' => 'fas fa-user-friends',    'permition' => 'viewEntity'],
            ['title' => 'Tipos de Entidades',       'url' => './entitytype',    'icon' => 'fas fa-users-cog',       'permition' => 'viewEntitytype'],
            ['title' => 'Carregadores',             'url' => './carrier',       'icon' => 'fas fa-user',            'permition' => 'viewCarrier'],
            ['title' => 'Tipos de Carregadores',    'url' => './carriertype',   'icon' => 'fas fa-user-cog',        'permition' => 'viewCarriertype'],
            ['title' => 'Utilizadores',             'url' => './user',          'icon' => 'fas fa-user-astronaut',  'permition' => 'viewUsers']
        ];

        foreach ($pages as $page) {
            if (Yii::$app->user->can($page['permition'])) {
                echo '<li class="nav-item"><i class="nav-icon ' . $page['icon'] . '"></i>' . Html::a($page['title'], Url::toRoute([$page['url']]), ['class' => 'nav-link']) . '</li>';
            }
        }
        ?>
    </ul>
</aside>

<div class="col wrap">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar shadow-sm navbar-expand-md navbar-light bg-white',
        ],
    ]);
    echo '  <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>';
    echo Breadcrumbs::widget([
        'itemTemplate' => "\n<li class=\"breadcrumb-item\"><b>{link}</b></li>\n",
        'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $loggedUser = User::findOne(Yii::$app->user->identity->getId());
        //$menuItems[] = '<select class="js-data-example-ajax"></select>';

        $menuItems[] = '<li class="nav-item">
                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="btn btn-link nav-link dropdown-toggle">Olá, <b>' . Yii::$app->user->identity->username . '</b></a>' .
                                Dropdown::widget([
                                    'encodeLabels' => false,
                                    'options' => ['class' => 'dropdown-menu-right'],
                                    'items' => [
                                        ['label' => '<i class="fas fa-user-astronaut text-primary mr-3"></i> Perfil', 'url' => Url::toRoute(['user/view', 'id' => Yii::$app->user->identity->getId()])],
                                        ['label' => '<i class="fas fa-home text-success mr-3"></i> Home', 'url' => Url::toRoute([Yii::$app->urlManagerFrontend->baseUrl])],
                                        Html::beginForm(['/site/logout'], 'post') . Html::submitButton(
                                            '<i class="fas fa-power-off text-warning mr-3"></i> Sair',
                                            ['class' => 'dropdown-item logout']
                                        ) . Html::endForm()
                                    ],
                                ])
                            .'</div>
                        </li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav float-right ml-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php
//$js = <<<SCRIPT
//$('.js-data-example-ajax').select2({
//  ajax: {
//    url: 'http://localhost/eventusgest/backend/web/api/accesspoint',
//    dataType: 'json'
//  }
//});
//SCRIPT;
//$this->registerJs($js);

$this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
