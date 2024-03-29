<?php

use common\models\Carrier;
use common\models\Carriertype;
use common\models\Credential;
use common\models\Entitytype;
use common\models\Event;
use common\models\Movement;
use pcrt\widgets\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Entity */
/* @var $carrierType common\models\CarrierType */

$b = Yii::$app->request->get('b') ? Yii::$app->request->get('b') : null;
$sendEmails = Event::findOne(Yii::$app->user->identity->getEvent())->sendEmails;
?>
    <div>
        <?php
            if ($b)
                echo Html::a('Voltar para o backend', ['go-back', 'id' => $model->id], ['class' => 'btn btn-primary mb-3'])
        ?>
    </div>

    <div class="card mb-5 shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-2 text-center d-flex">
                    <i class="fas fa-users fa-4x m-auto"></i>
                </div>
                <div class="col-8">
                    <h6><?= $model->idEntityType0->name ?></h6>
                    <h3 class="mb-0"><?= $model->name ?></h3>
                    <h5 class="font-weight-bold text-black-50 mb-0"><?= $model->ueid ?></h5>
                </div>
                <div class="col-2">
                    <div class="mt-3">
                        <span data-toggle="tooltip" data-boundary="window" title="Editar Dados">
                            <a class="btn btn-sm btn-action btn-success" data-toggle="collapse"
                               href="#entity" role="button" aria-expanded="false"
                               aria-controls="entity">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </span>
                        <?php
                        if (Yii::$app->user->can('sendEmails')) {
                        ?>
                            <span data-toggle="tooltip" data-boundary="window" title="Enviar email com as credenciais">
                                <?= $sendEmails ? Html::a('<i class="fa fa-inbox"></i>', ['send-all-credentials', 'ueid' => $model->ueid], ['class' => 'btn btn-sm btn-action btn-success']) : '' ?>
                            </span>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div id="entity" class="card-body border-top collapse">
            <?php $form = ActiveForm::begin(['options' => [
                'enctype' => 'multipart/form-data'
            ], 'action' => \yii\helpers\Url::to($b ? ['update', 'ueid' => $model->ueid, 'b' => $b] : ['update', 'ueid' => $model->ueid])]); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

<h3><?= count($model->credentials) ?> credenciais</h3>
<?php foreach ($model->credentials as $credential) { ?>
    <div class="card mb-3 shadow-sm">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-2">
                    <img width="130" height="130" src="../qrcodes/<?= $credential->ucid ?>.png" alt="">
                </div>
                <div class="col-8 p-3">
                    <h6 class="mt-3">Credencial</h6>
                    <h3 class="mb-0"><?= $credential->ucid ?></h3>
                    <p class="mb-0"><?= ($credential->flagged > 0 ? ' <small class="badge badge-warning"><i class="fas fa-flag"></i> ' . $credential->flagged . '</small>' : '') . ($credential->blocked == 1 ? ' <small class="badge badge-danger"><i class="fas fa-lock"></i> Bloqueada</small>' : '') ?></p>
                </div>
                <div class="col-2">
                    <div class="mt-5">
                        <span data-toggle="tooltip" data-boundary="window" title="Portador">
                            <a class="btn btn-sm btn-action btn-primary" data-toggle="collapse"
                               href="#carrier<?= $credential->ucid ?>" role="button" aria-expanded="false"
                               aria-controls="carrier">
                                <i class="fas fa-user"></i>
                            </a>
                        </span>
                        <span data-toggle="tooltip" data-boundary="window" title="Movimentos">
                            <a class="btn btn-sm btn-action btn-primary" data-toggle="collapse"
                               href="#movements<?= $credential->ucid ?>" role="button" aria-expanded="false"
                               aria-controls="movements">
                                <i class="fas fa-route"></i>
                            </a>
                        </span>
                        <?= ($credential->flagged > 0 || $credential->blocked == 1 ? '<a class="btn btn-sm btn-action btn-danger disabled" disabled><i class="fas fa-ban"></i></a>' : Html::a('<i class="fas fa-ban"></i>', $b ? ['delete-credential', 'id' => $credential->id, 'ueid' => $model->ueid, 'b' => $b] : ['delete-credential', 'id' => $credential->id, 'ueid' => $model->ueid], ['data-toggle' => 'tooltip', 'title' => 'Revogar', 'class' => 'btn btn-sm btn-action btn-danger', 'data' => [
                            'confirm' => 'Tem a certeza que pertende revogar esta credencial?',
                            'method' => 'post',
                            'boundary' => "window"]])) ?>

                        <?php
                        if (Yii::$app->user->can('sendEmails')) {
                        ?>
                            <span data-toggle="tooltip" data-boundary="window" title="Enviar email com esta credencial">
                                <?= $sendEmails ? Html::a('<i class="fa fa-inbox"></i>', ['send-credential', 'ueid' => $model->ueid, 'credential' => $credential->id], ['class' => 'btn btn-sm btn-action btn-success']) : '' ?>
                            </span>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div id="carrier<?= $credential->ucid ?>" class="card-body border-top collapse">
            <?php
            $carrier = (isset($credential->idCarrier0) ? $credential->idCarrier0 : new Carrier());
            $action = (isset($credential->idCarrier0) ? ['update-carrier', 'id' => $carrier->id, 'ueid' => $model->ueid] : $b ? ['create-carrier', 'ueid' => $model->ueid, 'b' => $b] : ['create-carrier', 'ueid' => $model->ueid]);

            $form = ActiveForm::begin(['options' => [
                'enctype' => 'multipart/form-data'
            ], 'action' => \yii\helpers\Url::to($action)]);

            echo '<div class="row"><div class="col-8">';
            echo $form->field($carrier, 'idCredential')->hiddenInput(['value' => $credential->id])->label(false);
            echo $form->field($carrier, 'name')->textInput(['maxlength' => true]);
            echo $form->field($carrier, 'info')->textInput(['maxlength' => true]);
            echo $form->field($carrier, 'idCarrierType')->widget(Select2::className(), ['options' => ['placeholder' => 'Selecione'],
                    'items' => ArrayHelper::map($carrierType, 'id', 'name'),
                    ]);
            echo '</div>
                <div class="col-4">
                    <img class="shadow-sm radius-round border border-white overflow-hidden profile-image" width="150" height="150" src="'. Yii::$app->request->baseUrl . '/uploads/carriers/' . ( $carrier->photo != null ? $carrier->photo : 'default.png' ) .'" alt="">
                ';
            echo $form->field(new \common\models\UploadPhoto(), 'photoFile')->fileInput();
            echo '</div></div><div class="row"><div class="col-12">';

            echo Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success']);
            echo '</div></div>';
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
                    foreach ($credential->movements as $movement) {
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
<?php } ?>

<?php if (count($model->credentials) < $model->maxCredentials) { ?>
    <a class="card card-new text-decoration-none" data-method="post"
       href="<?= \yii\helpers\Url::to($b ? ['create-credential', 'ueid' => $model->ueid, 'b' => $b] : ['create-credential', 'ueid' => $model->ueid]) ?>">
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

<?php if (count($model->credentials)+2 <= $model->maxCredentials) { ?>
<?= Html::beginForm($b ? ['create-multiple-credentials', 'ueid' => $model->ueid, 'b' => $b] : ['create-multiple-credentials', 'ueid' => $model->ueid], 'get', ['enctype' => 'multipart/form-data']) ?>
    <hr class="mt-4">
    <div class="row">
        <div class="col-12">
            <h6 class="mt-2 mb-2">Criar Credenciais em massa</h6>
            <div class="d-flex">
                <?= Html::input('number', 'amount', 2, ['class' => 'w-auto form-control','min'=>'2','max'=>($model->maxCredentials-count($model->credentials))]) ?>
                <?= Html::submitButton('<i class="fa fa-plus"></i> Adicionar', ['class' => 'submit btn btn-success ml-3']) ?>
            </div>
        </div>
    </div>
<?= Html::endForm() ?>

<?php } ?>