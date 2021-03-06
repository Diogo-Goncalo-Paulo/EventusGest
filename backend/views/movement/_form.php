<?php

use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Movement */
/* @var $credentials common\models\Credential */
/* @var $accessPoint common\models\Accesspoint */
/* @var $areas common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$canCreateImpossibleMovement = Yii::$app->user->can('createImpossibleMovement');
?>

    <div class="movement-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'idCredential')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione uma credencial', 'disabled' => $this->params['type'] == 'update'], 'items' => ArrayHelper::map($credentials, 'id', 'ucid')]); ?>

        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 offset-4">
                        <?= $form->field($model, 'idAccessPoint', ['enableClientValidation' => false])->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['options' => ['id' => 'accessPoint', 'name' => 'no1', 'placeholder' => 'Selecione', 'disabled' => true, 'value' => Yii::$app->user->identity->getAccessPoint()], 'items' => ArrayHelper::map($accessPoint, 'id', 'name')]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <?= $form->field($model, 'idAreaFrom', ['enableClientValidation' => false])->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'idAreaFrom')->widget(Select2::className(), ['options' => ['id' => 'areaFrom', 'name' => 'no2', 'placeholder' => 'Selecione uma credencial', 'disabled' => true], 'items' => ArrayHelper::map($areas, 'id', 'name')]); ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'idAreaTo', ['enableClientValidation' => false])->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'idAreaTo')->widget(Select2::className(), ['options' => ['id' => 'areaTo', 'name' => 'no3', 'placeholder' => 'Selecione', 'disabled' => !$canCreateImpossibleMovement], 'items' => ArrayHelper::map($areas, 'id', 'name')]); ?>
                    </div>
                </div>
                <div id="alertImpMov" class="alert alert-danger font-weight-bold" role="alert" style="display: none">
                    <i class="fas fa-exclamation-triangle"></i> O movimento é impossivel!
                </div>
                <div id="alertNoAccess" class="alert alert-danger font-weight-bold" role="alert" style="display: none">
                    <i class="fas fa-exclamation-triangle"></i> Sem acesso á area!
                </div>
                <div class="form-group mb-0">
                    <?= Html::submitButton('Registar movimento', ['class' => 'btn btn-success btn-block', 'id' => 'btn-submit']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <div id="credInfo" class="card shadow-sm" style="display: none">
            <div class="card-body">
                <div class="row">
                    <div class="col-8 p-3">
                        <h6>Credencial</h6>
                        <h3 id="credUcid" class="mb-0">UCID</h3>
                        <p id="credStatus" class="mb-0"></p>
                    </div>
                    <div class="col-4">
                        <div class="mt-5">
                            <span data-toggle="tooltip" data-boundary="window" title="Movimentos">
                            <a class="btn btn-sm btn-action btn-primary" data-toggle="collapse"
                               href="#movements" role="button" aria-expanded="false"
                               aria-controls="movements">
                                <i class="fas fa-route"></i>
                            </a>
                        </span>
                            <button id="credBlock" data-credId="0" data-credAction="block" class="btn btn-sm btn-action"
                                    data-toggle="tooltip" title="Bloquear/Desbloquear">
                                <i class="fas fa-lock"></i>
                            </button>
                            <button id="credFlag" data-credId="0" class="btn btn-sm btn-action btn-warning">
                                <i class="fas fa-flag"></i>
                                <span class="font-weight-bold text-uppercase">Marcar como suspeita</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="movements" class="card-body border-top collapse">
                <table class="table table-eg table-hover mb-0">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>De <i class="fas fa-arrow-right"></i> Para</th>
                    </tr>
                    </thead>
                    <tbody id="credMoves">
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<?php
$authKey = Yii::$app->getRequest()->getCookies()->getValue('user-auth');
$url = Yii::$app->getHomeUrl();
$canCreateImpossibleMovement = ($canCreateImpossibleMovement ? 1 : 0);
$js = /** @lang JavaScript */
    <<<SCRIPT
// noinspection JSAnnotator
const canCreateImpossibleMovement = $canCreateImpossibleMovement;

let credFlagBtn = $("#credFlag").click(b => {
    blockOrFlag("flag", credFlagBtn.attr("data-credId"))
}), credBlockBtn = $("#credBlock").click(b => {
    blockOrFlag(credBlockBtn.attr("data-credAction"), credBlockBtn.attr("data-credId"))
}), blockbtn = false;
function blockOrFlag(type, id) {
    $.ajax({
        type: "PUT",
        url: "$url" + "api/credential/" + type +"/" + id,
        headers: {
            Authorization: 'Basic $authKey'
        },
        success: e => {
            updateStatus(e)
        },
        dataType: 'json'
    }).fail((e) => {
        console.log(e)
    });
}

$('#movement-idcredential').select2({
    ajax: {
        url: '$url' + 'api/credential/search',
        headers: {
            Authorization: 'Basic $authKey'
        },
        dataType: 'json',
        delay: 200,
        processResults: (data) => {
            return {
                results: data.map( arr => {
                    if (arr.ucid)
                        Object.assign(arr, {text: arr.ucid});
                    return arr;
                })
            };
        },
        cache: true
    },
    minimumInputLength: 3
}).on("change", (a) => {
    $.ajax({
        type: "GET",
        url: "$url" + "api/credential/" + a.target.value ,
        headers: {
            Authorization: 'Basic $authKey'
        },
        success: Credential,
        dataType: 'json'
    }).fail((e) => {
        console.log(e)
    });
    updateInputs();
});

const Credential = cred => {
    cred = cred[0];
    $("#areaFrom").val(cred.idCurrentArea).trigger('change');
    let apId = $("#accessPoint").val();
    
    $.ajax({
        type: "GET",
        url: "$url" + "api/accesspoint/" + apId ,
        headers: {
            Authorization: 'Basic $authKey'
        },
        success: (e) => {
            AccessPoint(e, cred)
        },
        dataType: 'json'
    }).fail((e) => {
        console.log(e)
    });
    
    
    $("#credUcid").html(cred.ucid);
    updateStatus(cred);
    
    $.ajax({
        type: "GET",
        url: "$url" + "api/movement/credential/" + cred.id ,
        headers: {
            Authorization: 'Basic $authKey'
        },
        success: Movements,
        dataType: 'json'
    }).fail((e) => {
        console.log(e)
    });
    
    $("#credInfo").fadeIn();
    console.log(cred);
    updateInputs();
}, Movements = moves => {
    let html = '';
    moves.forEach(mov => {
        let date = new Date(mov.time),
            d = new Intl.DateTimeFormat('pt').format(date);
        html += '<tr><td>' + d + ' ' + date.getHours() + ':' + date.getMinutes() + '</td><td>' + mov.nameAreaFrom + ' <i class="fas fa-arrow-right" data-toggle="tooltip" title="' + mov.nameAccessPoint + '"></i> ' + mov.nameAreaTo + '</td></tr>';
    });
    $("#credMoves").html(html);
    updateInputs();
}, AccessPoint = (ap,cred) => {
    console.log(ap)
    let area2 = $("#areaTo"),
        alert = $("#alertImpMov").hide(),
        alert2 = $("#alertNoAccess").hide(),
        btn = $("#btn-submit");
    area2.prop( "disabled", false ).trigger('change');
   
    if (ap.areas.find(area => area === cred.idCurrentArea)) {
        let area = ap.areas.find(area => area !== cred.idCurrentArea);
        area2.val(area).trigger('change').prop( "disabled", true );
        blockbtn = false;
        if (!checkAccess(cred, area)) {
            alert2.show();
            if (!canCreateImpossibleMovement)
                blockbtn = true;
        }
    } else {
        alert.show();
        if (!canCreateImpossibleMovement) {
            blockbtn = true;
            area2.trigger('change').prop( "disabled", true );
            btn.prop("disabled", true);
        }
    }
    updateStatus(cred);
    updateInputs();
};
$(document).ready(() => {
    $("#areaTo").on("change",() => {updateInputs()});
    $("#areaFrom").on("change",() => {updateInputs()});
    $("#accesspoint").on("change",() => {updateInputs()});
})

function checkAccess(cred, area) {
    return cred.accessibleAreas.find(a => a === area) === area;
}

function updateStatus(cred) {
    credFlagBtn.attr("data-credId", cred.id);
    credBlockBtn.attr("data-credId", cred.id);
    let blockedHtml = '';
    if (cred.blocked === 1) {
        credBlockBtn.addClass("btn-warning").removeClass("btn-danger");
        credBlockBtn.attr("data-credAction", "unblock" );
        $("#btn-submit").prop("disabled", true);
        blockedHtml = ' <small class="badge badge-danger"><i class="fas fa-lock"></i> Bloqueada</small>';
    } else {
        credBlockBtn.addClass("btn-danger").removeClass("btn-warning");
        $("#btn-submit").prop("disabled", blockbtn );
        credBlockBtn.attr("data-credAction", "block" );
    }
    $("#credStatus").html((cred.flagged > 0 ? ' <small class="badge badge-warning"><i class="fas fa-flag"></i> ' + cred.flagged + '</small>' : '') + blockedHtml);
}

function updateInputs() {
    const inputAreaFrom = $("#movement-idareafrom"),
          inputAreaTo = $("#movement-idareato"),
          inputAccessPoint = $("#movement-idaccesspoint");
    inputAreaFrom.val($("#areaFrom").val())
    inputAreaTo.val($("#areaTo").val())
    inputAccessPoint.val($("#accessPoint").val())
}
SCRIPT;
$this->registerJs($js);
?>