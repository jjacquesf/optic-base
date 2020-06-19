<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4 my-5 text-center">
            <h3 class="danger"><?= Yii::t('app', 'No se pudo completar el pago.'); ?></h3>
            <p><?= Yii::t('app', $model->getErrorMessage($model->Status)); ?></p>
        </div>
    </div>
</div>