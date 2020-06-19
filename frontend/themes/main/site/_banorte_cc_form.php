<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */
use frontend\assets\ThemeAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;
use frontend\modules\banorte\models\CardForm;
$assets = ThemeAsset::register($this);

$model = new CardForm();
// $model->card_holder = 'JORGE ALBERTO JACQUES';
// $model->card = '5549003002830934';
// $model->expires = '11/23';
// $model->cvv = '664';
// $model->card_type = '';


$this->registerJs('
    $("#card_number").validateCreditCard(function(e) {

        if(e.valid) {
            if(e.card_type.name == "visa") {
                $("#cardform-card_type").val("VISA");
            } else if(e.card_type.name == "mastercard") {
                $("#cardform-card_type").val("MC");
            } else {
                $("#cardform-card_type").val("");
            }
        }

        return $(this).removeClass(), null == e.card_type ? void $(".vertical.maestro").slideUp({
            duration: 200
        }).animate({
            opacity: 0
        }, {
            queue: !1,
            duration: 200
        }) : ($(this).addClass(e.card_type.name), "maestro" === e.card_type.name ? $(".vertical.maestro").slideDown({
            duration: 200
        }).animate({
            opacity: 1
        }, {
            queue: !1
        }) : $(".vertical.maestro").slideUp({
            duration: 200
        }).animate({
            opacity: 0
        }, {
            queue: !1,
            duration: 200
        }), e.valid ? $(this).addClass("valid") : $(this).removeClass("valid"))


    }, { accept: ["visa", "mastercard"]});

    $("#cardform-expires").mask("00/00");

', View::POS_READY);

?>
<?php if(Yii::$app->session->hasFlash('payment-error')): ?>
    <div class="alert alert-danger" role="alert">
        <h5><?= Yii::t('app', 'Error al procesar el pago.'); ?></h5>
        <p><?= Yii::$app->session->getFlash('payment-error'); ?></p>
    </div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('payment-success')): ?>
    <div class="alert alert-success" role="alert">
        <h5><?= Yii::t('app', 'Pago recibido correctamente.'); ?></h5>
        <p><?= Yii::$app->session->getFlash('payment-success'); ?></p>
    </div>
<?php endif; ?>

<?php 
    $form = ActiveForm::begin([
        'id' => 'banorte-cc-form',
        'action' => ['/banorte/default/3d-secure', 'travel_id' => $travelModel->id],
        'options' => ['class' => 'card-form']
    ]);
    echo Html::activeHiddenInput($model, 'card_type');
?>
    <h4><i class="fas fa-credit-card d-inline mr-3"></i>Pagar con tarjeta de crédito / débito.</h4>
    <ul>
        <li>
            <label for="card_number">Tarjeta</label>
            <?= Html::activeTextInput($model, 'card', ['id' => 'card_number', 'class' => '', 'placeholder' => '1234 5678 9012 3456']); ?>
        </li>

        <li class="vertical">
            <ul>
                <li>
                    <label for="expiry_date">Expira</label>
                    <?= Html::activeTextInput($model, 'expires', ['maxlength' => 5, 'placeholder' => 'mm/aa']); ?>
                </li>

                <li>
                    <label for="cvv">CVV</label>
                    <?= Html::activePasswordInput($model, 'cvv', ['maxlength' => 3, 'placeholder' => '123']); ?>
                </li>
            </ul>
        </li>

        <li>
            <label for="name_on_card">Nombre en la tarjeta</label>
            <?= Html::activeTextInput($model, 'card_holder', ['maxlength' => 60, 'placeholder' => 'Juan Perez']); ?>
        </li>
        <li>
            <button type="submit" class="btn btn-success btn-block"><i class="fas fa-credit-card d-inline mr-3"></i> <?= Yii::t('app', 'Pagar ahora'); ?></button>
        </li>
    </ul>
<?php ActiveForm::end(); ?>