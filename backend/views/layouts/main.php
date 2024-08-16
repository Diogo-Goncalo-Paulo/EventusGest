<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
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
    <meta name=description content="O EventusGest é um software de gestão de credenciais de eventos">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Yii::$app->name . ' - ' . Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="https://kit.fontawesome.com/d7254eeaba.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            ['title' => 'Eventos',                  'url' => ['event/index'],         'icon' => 'fas fa-calendar',        'permition' => 'viewEvent'],
            ['title' => 'Áreas',                    'url' => ['area/index'],          'icon' => 'fas fa-map',             'permition' => 'viewArea'],
            ['title' => 'Pontos de Acesso',         'url' => ['accesspoint/index'],   'icon' => 'fas fa-door-open',       'permition' => 'viewAccesspoint'],
            ['title' => 'Movimentos',               'url' => ['movement/index'],      'icon' => 'fas fa-route',           'permition' => 'viewMovement'],
            ['title' => 'Credenciais',              'url' => ['credential/index'],    'icon' => 'fas fa-id-card-alt',     'permition' => 'viewCredential'],
            ['title' => 'Entidades',                'url' => ['entity/index'],        'icon' => 'fas fa-user-friends',    'permition' => 'viewEntity'],
            ['title' => 'Tipos de Entidades',       'url' => ['entitytype/index'],    'icon' => 'fas fa-users-cog',       'permition' => 'viewEntitytype'],
            ['title' => 'Portadores',             'url' => ['carrier/index'],       'icon' => 'fas fa-user',            'permition' => 'viewCarrier'],
            ['title' => 'Tipos de Portadores',    'url' => ['carriertype/index'],   'icon' => 'fas fa-user-cog',        'permition' => 'viewCarriertype'],
            ['title' => 'Utilizadores',             'url' => ['user/index'],          'icon' => 'fas fa-user-astronaut',  'permition' => 'viewUsers']
        ];

        foreach ($pages as $page) {
            if (Yii::$app->user->can($page['permition'])) {
                echo '<li class="nav-item"><i class="nav-icon ' . $page['icon'] . '"></i>' . Html::a($page['title'], Url::toRoute($page['url']), ['class' => 'nav-link','name'=>$page['title']]) . '</li>';
            }
        }
        ?>
    </ul>
</aside>
<div class="col wrap">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar sticky-top shadow-sm navbar-expand-md navbar-light bg-white',
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
    echo '<div class="d-flex ml-auto">
            <div data-toggle="tooltip" title="O seu Ponto de Acesso atual" class="mr-2">
                <select id="user-accesspoint-qc" style="width: 8rem;"></select>
            </div>
            <div data-toggle="tooltip" title="O seu Evento atual">
                <select id="user-currentevent-qc" style="width: 8rem"></select>
            </div>
        </div>';
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
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
                                            ['class' => 'dropdown-item logout','name'=>'logout-button'],
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

$authKey = Yii::$app->getRequest()->getCookies()->getValue('user-auth');
$url = Yii::$app->getHomeUrl();
$userID = Yii::$app->user->getId();
$username = Yii::$app->user->identity->username;
$accessPoint = Yii::$app->user->identity->getAccessPoint();
$currentEvent = Yii::$app->user->identity->getEvent();
$js = <<<JS
var ac = $('#user-accesspoint-qc').select2({
    placeholder: "Selecione o ponto de acesso",
    ajax: {
        url: '$url' + 'api/accesspoint/search',
        headers: {
            Authorization: 'Basic $authKey'
        },
        dataType: 'json',
        
        delay: 200,
        processResults: (data) => {
            return {
                results: data.map( arr => {
                    if (arr.id)
                        Object.assign(arr, {text: arr.name});
                    return arr;
                })
            };
        },
        cache: true
    },
    minimumInputLength: 3
}).on("change", (a) => {
    $.ajax({
        type: "PUT",
        url: "$url" + "api/user/accesspoint/$userID" ,
        headers: {
            Authorization: 'Basic $authKey'
        },
        data: {
            accessPointId: a.target.value
        },
        success: e => {
            ac.val('')
            console.log(e)
        },
        dataType: 'json'
    }).fail(() => {
        a.target.value = null;
    });
});
var ce = $('#user-currentevent-qc').select2({
    placeholder: "Selecione o evento",
    ajax: {
        url: '$url' + 'api/event/search/$userID',
        headers: {
            Authorization: 'Basic $authKey'
        },
        dataType: 'json',
        delay: 200,
        processResults: (data) => {
            return {
                results: data.map( arr => {
                    if (arr.id)
                        Object.assign(arr, {text: arr.name});
                    return arr;
                })
            };
        },
        cache: true
    },
    minimumInputLength: 3
}).on("change", (a) => {
    $.ajax({
        type: "PUT",
        url: "$url" + "api/user/event/$userID" ,
        headers: {
            Authorization: 'Basic $authKey'
        },
        data: {
            eventId: a.target.value
        },
        success: e => {
            console.log(e)
        },
        dataType: 'json'
    }).fail(() => {
        a.target.value = null;
    });
});
JS;
$this->registerJs($js);

$this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>