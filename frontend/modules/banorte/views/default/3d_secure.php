<?php
    use yii\web\View;
    $this->registerJs('
        //setTimeout(function(){ $("#payment-button").trigger("click"); }, 2000);
    ', View::POS_READY);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4 my-5 text-center">
            <h3><?= Yii::t('app', 'Estamos conectando con el banco emisor...'); ?></h3>
            <p><?= Yii::t('app', 'Click en el botón "Continuar" si no se redirige automáticamente.'); ?></p>

            <i class="fa fa-spinner fa-spin fa-3x fa-fw my-2"></i>
            <span class="sr-only"><?= Yii::t('app', 'Conectando con el banco emisor ...'); ?></span>


            <form action="https://eps.banorte.com/secure3d/Solucion3DSecure.htm">
                <input type="hidden" name="Card" value="<?= $cardModel->card; ?>"/>
                <input type="hidden" name="Expires" value="<?= $cardModel->expires; ?>"/>
                <input type="hidden" name="Total" value="<?= $total; ?>"/>
                <input type="hidden" name="CardType" value="<?= $cardModel->card_type; ?>"/>
                <input type="hidden" name="MerchantId" value="<?= Yii::$app->banorte->merchant_id; ?>"/>
                <input type="hidden" name="MerchantName" value="<?= Yii::$app->banorte->merchant_name; ?>"/>
                <input type="hidden" name="MerchantCity" value="<?= Yii::$app->banorte->merchant_city; ?>"/>
                <input type="hidden" name="ForwardPath" value="<?= $response_url; ?>"/>
                <input type="hidden" name="Cert3D" value="<?= Yii::$app->banorte->cert_3d; ?>"/>
                <input type="hidden" name="Reference3D" value="<?= $model->reference; ?>"/>


                <button id="payment-button" type="submit" class="btn btn-success my-5">
                    <?= Yii::t('app', 'Continuar con la autorización ...'); ?>
                </button>
            </form>
        </div>
    </div>
</div>