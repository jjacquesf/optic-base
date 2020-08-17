<?php 
    use common\models\Travel;
    use frontend\models\FlightInfoForm;
    use yii\web\View;
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;

    $this->registerJs('

    $(".payment-method-btn").on("click", function(e) {
        e.preventDefault();
        var pm = $(this).data("pm");

        if(pm == "banorte-card-form") {
            $("#paypal-form").hide();
            $("#banorte-card-form").show();
        } else if(pm == "paypal-form") {
            $("#banorte-card-form").hide();
            $("#paypal-form").show();
        }
    });

    ', View::POS_READY);
?><div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 my-3 mb-4 col-sm-8">
            <h4><?= Yii::t('app', 'Reservación #'); ?>: <?= $model->reference; ?></h4>
            <div class="card-form" id="site-paypal">
                <div class="row">
                    <?= $model->getFormatted('card'); ?>
                    <?php if($model->payed_status == Travel::PAYED_STATUS_COMPLETE): ?>
                        <div class="col-xs-12">
                            <h5><?= Yii::t('app', 'Información del vuelo'); ?></h5>
                            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <?= $form->field($flightModel, 'flight')->textInput(['autofocus' => true]) ?>
                                </div>
                                <div class="col-xs-6">
                                    <?= $form->field($flightModel, 'airline')->dropDownList($model->airline_options) ?>
                                </div>
                                <div class="col-xs-12">
                                    <?= $form->field($flightModel, 'passangers')->textarea(['rows' => 3]) ?>
                                </div>
                                <div class="col-xs-12">
                                    <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success btn-block', 'name' => 'flight-button']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    <?php else: ?>
                        <div class="col-xs-12">
                            <h5><?= Yii::t('app', 'Información del vuelo'); ?></h5>
                            <p><?= Yii::t('app', 'Debes realizar tu pago para completar la información de tu vuelo.'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 my-3 mb-4 col-sm-4">
            <h4>&nbsp;</h4>
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

            <?php if($model->payed_status == Travel::PAYED_STATUS_PENDING): ?>
                <h4><?= Yii::t('app', 'Seleccione la forma de pago'); ?></h4>
                <div class="row">
                    <div id="banorte-card-form" class="col-xs-12">
                        <?= $this->render('_paypal_form', ['travelModel' => $model]); ?>
                        <p class="text-center my-3"><?= Yii::t('app', 'ó'); ?></p>
                        <?= $this->render('_banorte_cc_form', ['travelModel' => $model]); ?>
                    </div>
                </div>
            <?php else: ?>
                <?= $this->render('_travel_payments', ['model' => $model]); ?>
            <?php endif; ?>
        </div>
    </div>
</div>