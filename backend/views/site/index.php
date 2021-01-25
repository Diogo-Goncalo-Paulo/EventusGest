<?php

/* @var $this yii\web\View */

use common\models\Movement;
use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJsFile('js/jquery.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js/select2.js', ['depends' => [\pcrt\widgets\select2\Select2Asset::className()]]);

$this->title = 'Dashboard';
?>
<div class="row">
    <div class="col-12">
        <h1 class="d-inline">Movimentos recentes</h1>
        <div class="card bg-white p-3 mt-3 shadow-sm">
            <div class="row">
                <div class="col-12">
                    <table class="table table-eg table-hover mb-0">
                        <thead>
                        <tr>
                            <th>Data</th>
                            <th>De <i class="fas fa-arrow-right"></i> Para</th>
                            <th>Porteiro</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="movements">
                        <?php
                        $movements = Movement::find()->orderBy("time DESC")->limit(10)->all();
                        if ($movements > 0) {
                            foreach ($movements as $movement) {
                                echo '<tr>
                                    <td>' . date_format(date_create($movement['time']), 'd/m/Y H:i') . '</td>
                                    <td>' . $movement['idAreaFrom0']['name'] . ' <i class="fas fa-arrow-right" data-toggle="tooltip" title="' . $movement['idAccessPoint0']['name'] . '"></i> ' . $movement['idAreaTo0']['name'] . '</td>
                                    <td>' . (isset($movement['idUser0']['displayName']) ? $movement['idUser0']['displayName'] : $movement['idUser0']['username']) . '</td>
                                    <td>' . (Yii::$app->user->can('viewMovement') ? Html::a('<i class="fas fa-eye"></i>', ['movement/view', 'id' => $movement['id']], ['data-toggle' => 'tooltip', 'title' => 'Ver Movimento', 'class' => 'btn btn-sm btn-action btn-primary']) : '<a class="btn btn-sm btn-action btn-primary disabled" disabled><i class="fas fa-eye"></i></a>') . '</td>
                                </tr>';
                            }
                        } else {
                            echo '<tr>Sem movimentos</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button id="refresh" class="btn btn-action btn-success mt-2"><i class="fas fa-sync"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$authKey = Yii::$app->getRequest()->getCookies()->getValue('user-auth');
$url = Yii::$app->getHomeUrl();
$viewurl = Url::toRoute('movement/view');
$js = <<<JS
$(document).ready(() => {
    const Movements = moves => {
        moves.length = 10;
        setTimeout(() => {btn.find('.fas').removeClass('fa-spin')}, 500);
        let html = '';
        moves.forEach(mov  => {
            let date = new Date(mov.time),
                d = new Intl.DateTimeFormat('pt').format(date);
            html += '<tr><td>' + d + ' ' + date.getHours() + ':' + date.getMinutes() + '</td><td>' + mov.nameAreaFrom + ' <i class="fas fa-arrow-right" data-toggle="tooltip" title="' + mov.nameAccessPoint + '"></i> ' + mov.nameAreaTo + '</td><td>' + mov.nameUser + '</td><td>' +
             '<a class="btn btn-sm btn-action btn-primary" href="$url?id=' + mov.id + '" title="" data-toggle="tooltip" data-original-title="Ver Movimento"><i class="fas fa-eye" aria-hidden="true"></i></a></td></tr>';
        });
        $("#movements").html(html);
    }
    let btn = $("#refresh").click(() => {
        btn.find('.fas').addClass('fa-spin');
        $.ajax({
            type: "GET",
            url: "$url" + "api/movement/" ,
            headers: {
                Authorization: 'Basic $authKey'
            },
            success: Movements,
            dataType: 'json'
        }).fail((e) => {
            console.log(e)
        });
    });
});

JS;
$this->registerJS($js);
?>

