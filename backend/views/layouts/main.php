<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
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
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-light bg-white',
        ],
    ]);
    echo Breadcrumbs::widget([
        'itemTemplate' => "\n<li class=\"breadcrumb-item\"><b>{link}</b></li>\n",
        'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li class="nav-item d-flex"><i class="fas fa-user-circle my-auto"></i>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::$app->user->identity->username,
                ['class' => 'btn btn-link nav-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav float-right ml-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <aside class="bg-info">
        <ul class="nav sidebar">
            <li class="nav-item"><i class="nav-icon fas fa-home"></i><?= Html::a(Yii::$app->name, Yii::$app->homeUrl, ['class' => 'nav-link']) ?></li>
            <?php
            $pages = [
                ['title' => 'Eventos',                  'url' => './event',         'icon' => 'fas fa-calendar'],
                ['title' => 'Areas',                    'url' => './area',          'icon' => 'fas fa-map'],
                ['title' => 'Movimentos',               'url' => './movement',      'icon' => 'fas fa-route'],
                ['title' => 'Credenciais',              'url' => './credential',    'icon' => 'fas fa-id-card-alt'],
                ['title' => 'Entidades',                'url' => './entity',        'icon' => 'fas fa-users'],
                ['title' => 'Tipos de Entidades',       'url' => './entitytype',    'icon' => 'fas fa-users'],
                ['title' => 'Carregadores',             'url' => './carrier',       'icon' => 'fas fa-user'],
                ['title' => 'Tipos de Carregadores',    'url' => './carriertype',   'icon' => 'fas fa-user-tag']
            ];

            foreach ($pages as $page) {
                echo '<li class="nav-item"><i class="nav-icon ' . $page['icon'] . '"></i>' . Html::a($page['title'], Url::toRoute([$page['url']]), ['class' => 'nav-link']) . '</li>';
            }
            ?>
        </ul>
    </aside>

    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
