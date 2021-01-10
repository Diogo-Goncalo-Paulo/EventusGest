<?php

use common\models\Accesspoint;
use common\models\Area;
use common\models\Credential;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Movement */
/* @var $form yii\widgets\ActiveForm */

$subquery = Area::find()->select('id')->where(['idEvent' => Yii::$app->user->identity->getEvent()]);

?>

    <div class="movement-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'idCredential')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione uma credencial', 'disabled' => $this->params['type'] == 'update'], 'items' => ArrayHelper::map(Credential::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'ucid')]); ?>

        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 offset-4">
                        <?= $form->field($model, 'idAccessPoint')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione', 'disabled' => 'true', 'value' => Yii::$app->user->identity->getAccessPoint()], 'items' => ArrayHelper::map(Accesspoint::find()->where(['id' => Yii::$app->user->identity->getAccessPoint()])->all(), 'id', 'name')]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <?= $form->field($model, 'idAreaFrom')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione uma credencial', 'disabled' => true], 'items' => ArrayHelper::map(Area::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name')]); ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'idAreaTo')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'], 'items' => ArrayHelper::map(Area::find()->where(['idEvent' => Yii::$app->user->identity->getEvent()])->all(), 'id', 'name')]); ?>
                    </div>
                </div>
                <div id="alertImpMov" class="alert alert-danger font-weight-bold" role="alert" style="display: none">
                    <i class="fas fa-exclamation-triangle"></i> O movimento é impossivel!
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
                        <span data-toggle="tooltip" data-boundary="window" title="Carregador">
                            <a class="btn btn-sm btn-action btn-primary" data-toggle="collapse"
                               href="#carrier" role="button" aria-expanded="false"
                               aria-controls="carrier">
                                <i class="fas fa-user"></i>
                            </a>
                        </span>
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
            <div id="carrier" class="card-body border-top collapse">
                <?php
                //            $carrier = (isset($credential->idCarrier0) ? $credential->idCarrier0 : new Carrier());
                //            $action = (isset($credential->idCarrier0) ? ['update-carrier', 'id' => $carrier->id, 'ueid' => $model->ueid] : ['create-carrier', 'ueid' => $model->ueid]);
                //            $form = ActiveForm::begin(['options' => [
                //                'enctype' => 'multipart/form-data'
                //            ], 'action' => \yii\helpers\Url::to($action)]);
                //
                //            echo '<div class="row"><div class="col-8">';
                //            echo $form->field($carrier, 'idCredential')->hiddenInput(['value' => $credential->id])->label(false);
                //            echo $form->field($carrier, 'name')->textInput(['maxlength' => true]);
                //            echo $form->field($carrier, 'info')->textInput(['maxlength' => true]);
                //            echo $form->field($carrier, 'idCarrierType')->widget(Select2::className(), [
                //                'items' => ArrayHelper::map(Carriertype::find()->where(['deletedAt' => null])->andWhere(['idEvent' => $model->idEntityType0->idEvent])->all(), 'id', 'name'),
                //            ]);
                //            echo '</div>
                //                <div class="col-4">
                //                    <img class="shadow-sm radius-round border border-white overflow-hidden profile-image" width="150" height="150" src="'. Yii::$app->request->baseUrl . '/uploads/carriers/' . ( $carrier->photo != null ? $carrier->photo : 'default.png' ) .'" alt="">
                //                ';
                //            echo $form->field(new \common\models\UploadPhoto(), 'photoFile')->fileInput();
                //            echo '</div></div><div class="row"><div class="col-12">';
                //
                //            echo Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success']);
                //            echo '</div></div>';
                //            ActiveForm::end();
                ?>
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
$canCreateImpossibleMovement = Yii::$app->user->can('createImpossibleMovement');
$js = /** @lang JavaScript */
    <<<SCRIPT
let credFlagBtn = $("#credFlag").click(b => {
    blockOrFlag("flag", credFlagBtn.attr("data-credId"))
}), credBlockBtn = $("#credBlock").click(b => {
    blockOrFlag(credBlockBtn.attr("data-credAction"), credBlockBtn.attr("data-credId"))
});
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
});

const Credential = cred => {
    cred = cred[0];
    $("#movement-idareafrom").val(cred.idCurrentArea).trigger('change');
    let apId = $("#movement-idaccesspoint").val();
    
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
}, Movements = moves => {
    let html = '';
    moves.forEach(mov => {
        let date = new Date(mov.time),
            d = new Intl.DateTimeFormat('pt').format(date);
        html += '<tr><td>' + d + ' ' + date.getHours() + ':' + date.getMinutes() + '</td><td>' + mov.nameAreaFrom + ' <i class="fas fa-arrow-right" data-toggle="tooltip" title="' + mov.nameAccessPoint + '"></i> ' + mov.nameAreaTo + '</td></tr>';
    });
    $("#credMoves").html(html);
}, AccessPoint = (ap,cred) => {
    console.log(ap)
    let area2 = $("#movement-idareato"),
        alert = $("#alertImpMov").hide(),
        btn = $("#btn-submit");
    area2.prop( "disabled", false ).trigger('change');
   
    if (ap.areas.find(area => area === cred.idCurrentArea)) {
       area2.val(ap.areas.find(area => area !== cred.idCurrentArea)).trigger('change').prop( "disabled", true );
    } else {
        alert.show();
        if (!$canCreateImpossibleMovement) {
            area2.trigger('change').prop( "disabled", true );
            btn.prop("disabled", true);
        }
    }
    
};

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
        $("#btn-submit").prop("disabled", false);
        credBlockBtn.attr("data-credAction", "block" );
    }
    $("#credStatus").html((cred.flagged > 0 ? ' <small class="badge badge-warning"><i class="fas fa-flag"></i> ' + cred.flagged + '</small>' : '') + blockedHtml);
}
SCRIPT;
$this->registerJs($js);
?>