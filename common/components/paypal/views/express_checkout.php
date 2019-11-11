<?php 
use yii\helpers\Html;
use yii\web\View;

$this->registerJS('setTimeout(function(){ $("#express-checkout-form").click(); }, 2000);', View::POS_READY);

?>

<?= Html::beginForm($paypal_url, 'POST', ['id' => 'express-checkout-form']); ?>
<?= Html::hiddenInput('business', $business_account); ?>
<?= Html::hiddenInput('notify_url', $ipn_url); ?>
<?= Html::hiddenInput('cancel_return', $cancel_url); ?>
<?= Html::hiddenInput('return', $success_url); ?>

<?php $i = 1;?>
<?php foreach($items as $item): ?>
	<?= Html::hiddenInput("quantity_{$i}", $item['qty']); ?>
	<?= Html::hiddenInput("item_name_{$i}", $item['name']); ?>
	<?= Html::hiddenInput("amount_{$i}", sprintf('%.2f',$item['amount'])); ?>
	<?= Html::hiddenInput("shipping_{$i}", sprintf('%.2f',$item['shipping'])); ?>
	<?= Html::hiddenInput("shipping2_{$i}", sprintf('%.2f',0)); ?>
	<?php $i++; ?>
<?php endforeach; ?>

<?= Html::hiddenInput('discount_amount_cart', $discount); ?>
<?= Html::hiddenInput('currency_code', $currency_code); ?>
<?= Html::hiddenInput('charset', 'utf-8'); ?>
<?= Html::hiddenInput('cmd', '_cart'); ?>
<?= Html::hiddenInput('upload', '1'); ?>

<?= Html::submitButton('Pagar ahora');?>

<?= Html::beginForm(); ?>