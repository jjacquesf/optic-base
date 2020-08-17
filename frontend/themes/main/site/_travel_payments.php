<?php

/* @var $this yii\web\View */
use frontend\assets\ThemeAsset;
use yii\helpers\Html;
$assets = ThemeAsset::register($this);

?>
<?php foreach($model->payments as $payment): ?>
    <div class="card-form" id="travel-payments">
        <h4><i class="fas fa-credit-card d-inline mr-3"></i>Pago con tarjeta de crédito / débito.</h4>
        <p><?= $payment->getFormatted('details') ?></p>
        <p class="text-right" style="font-size: 1.3em;"><b><?= $payment->getFormatted('amount'); ?></b></p>
    </div>
<?php endforeach;?>