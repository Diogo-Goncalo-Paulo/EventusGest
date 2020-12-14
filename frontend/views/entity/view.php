<?php

use common\models\Carrier;
use common\models\Carriertype;
use common\models\Credential;
use common\models\Movement;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Entity */
?>

<div class="card mb-5 shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-2 text-center d-flex">
                <i class="fas fa-users fa-4x m-auto"></i>
            </div>
            <div class="col-10">
                <h6><?= $model->idEntityType0->name ?></h6>
                <h3 class="mb-0"><?= $model->name ?></h3>
                <h5 class="font-weight-bold text-black-50 mb-0"><?= $model->ueid ?></h5>
            </div>
        </div>
    </div>
</div>

<?php
$credentials = Credential::find()->where("idEntity = " . $model->id)->all();
foreach ($model->credentials as $credential) { ?>

    <div class="card mb-3 shadow-sm">
        <div class="card-body p-1">
            <div class="row">
                <div class="col-2">
                    <img width="150" height="150" src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1200px-QR_code_for_mobile_English_Wikipedia.svg.png" alt="">
                </div>
                <div class="col-8 p-3">
                    <h6 class="mt-3">Credencial</h6>
                    <h3 class="mb-0"><?= $credential->ucid ?></h3>
                    <p class="mb-0"><?= ($credential->flagged > 0 ? ' <small class="badge badge-warning"><i class="fas fa-flag"></i> ' . $credential->flagged . '</small>' : '') . ($credential->blocked == 1 ? ' <small class="badge badge-danger"><i class="fas fa-lock"></i> Bloqueada</small>' : '') ?></p>
                </div>
                <div class="col-2">
                    <div class="mt-5">
                        <span data-toggle="tooltip" data-boundary="window" title="Carregador">
                            <a class="btn btn-sm btn-action btn-primary" data-toggle="collapse" href="#carrier<?= $credential->ucid ?>" role="button" aria-expanded="false" aria-controls="carrier">
                                <i class="fas fa-user"></i>
                            </a>
                        </span>
                            <span data-toggle="tooltip" data-boundary="window" title="Movimentos">
                            <a class="btn btn-sm btn-action btn-primary" data-toggle="collapse" href="#movements<?= $credential->ucid ?>" role="button" aria-expanded="false" aria-controls="movements">
                                <i class="fas fa-route"></i>
                            </a>
                        </span>
                        <?= ( $credential->flagged > 0 || $credential->blocked == 1 ? '<a class="btn btn-sm btn-action btn-danger disabled" disabled><i class="fas fa-ban"></i></a>' : Html::a('<i class="fas fa-ban"></i>', ['delete', 'id' => $credential->id], ['data-toggle' => 'tooltip', 'title' => 'Revogar', 'class' => 'btn btn-sm btn-action btn-danger', 'data' => [
                            'confirm' => 'Tem a certeza que pertende revogar esta credencial?',
                            'method' => 'post',
                            'boundary' => "window" ]])) ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="carrier<?= $credential->ucid ?>" class="card-body border-top collapse">
            <?php
            $carrier = (isset($credential->idCarrier0) ? $credential->idCarrier0 : new Carrier());
                $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

                echo $form->field($carrier, 'name')->textInput(['maxlength' => true]);

                echo $form->field($carrier, 'info')->textInput(['maxlength' => true]);

                echo $form->field(new \common\models\UploadPhoto(), 'photoFile')->fileInput();

                echo $form->field($carrier, 'idCarrierType')->widget(Select2::className(), ['items' => ArrayHelper::map(Carriertype::find()->where(['deletedAt' => null])->andWhere(['idEvent' => $model->idEntityType0->idEvent])->all(), 'id', 'name')]);

                echo Html::submitButton('Save', ['class' => 'btn btn-success']);
                ActiveForm::end();
            ?>
        </div>
        <div id="movements<?= $credential->ucid ?>" class="card-body border-top collapse">
            <table class="table table-eg table-hover mb-0">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>De <i class="fas fa-arrow-right"></i> Para</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($credential->movements > 0) {
                        foreach ( $credential->movements as $movement) {
                            echo '
                                <tr>
                                    <td>' . date_format(date_create($movement['time']), 'd/m/Y H:i') . '</td>
                                    <td>' . $movement->idAreaFrom0->name . ' <i class="fas fa-arrow-right" data-toggle="tooltip" title="' . $movement->idAccessPoint0->name . '"></i> ' . $movement->idAreaTo0->name . '</td>
                                </tr>';
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

<?php }
if (count($model->credentials) < $model->idEntityType0->qtCredentials) { ?>

<a class="card card-new text-decoration-none" data-method="post" href="<?= \yii\helpers\Url::to(['create-credential', 'ueid' =>  $model->ueid]) ?>">
    <div class="card-body px-1">
        <div class="row">
            <div class="col-2 text-center d-flex">
                <i class="fas fa-id-card-alt fa-4x m-auto"></i>
            </div>
            <div class="col-10">
                <h6 class="mt-2 mb-0">Credencial</h6>
                <h3 class="mb-0">Adicionar Nova</h3>
            </div>
        </div>
    </div>
</a>

<?php } ?>