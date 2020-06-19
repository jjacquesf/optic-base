<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\ThemeAsset;
$assets = ThemeAsset::register($this);
?>
<div class="card-form" id="site-paypal">
    <div class="row">
        <div class="col-xs-12 text-center">
            <!-- <img src="<?= $assets->baseUrl; ?>/img/paypal.jpg" alt="Paypal" width="200"> -->
        </div>
        <div class="col-xs-12">
        <?= Html::beginForm(Yii::$app->paypalEC->getEndPoint(), 'POST', ['id' => 'express-checkout-form']); ?>
            <?= Html::hiddenInput('business', Yii::$app->paypalEC->business_account); ?>
            <?= Html::hiddenInput('notify_url', Yii::$app->paypalEC->ipn_url); ?>
            <?= Html::hiddenInput('cancel_return', Url::to(['/site/travel-detail', 'id' => $travelModel->id], true)); ?>
            <?= Html::hiddenInput('return', Url::to(['/site/travel-detail', 'id' => $travelModel->id], true)); ?>
            <?php // Html::hiddenInput('custom', '{{booking_reference}}'); ?>
            <input name="custom" value="<?= $travelModel->id; ?>" type="hidden">

            <?= Html::hiddenInput("quantity_1", '1'); ?>
            <?php // Html::hiddenInput("item_name_1", Yii::t('app', 'Reservación') . ' {{booking_reference}}'); ?>
            <?php //Html::hiddenInput("amount_1", '{{booking_total}}'); ?>
            <input name="item_name_1" value="<?= $travelModel->reference; ?>" type="hidden">
            <input name="amount_1" value="<?= $travelModel->total; ?>" type="hidden">

            <?= Html::hiddenInput('discount_amount_cart', '0.00'); ?>
            <?= Html::hiddenInput('currency_code', Yii::$app->paypalEC->currency_code); ?>
            <?= Html::hiddenInput('charset', 'utf-8'); ?>
            <?= Html::hiddenInput('cmd', '_cart'); ?>
            <?= Html::hiddenInput('upload', '1'); ?>

            <button type="submit" class="btn btn-success btn-block"><i class="fab fa-cc-paypal d-inline mr-3"></i> <?= Yii::t('app', 'Pagar con PayPal'); ?></button>
        <?= Html::endForm(); ?>

        </div>
    </div>
</div>
