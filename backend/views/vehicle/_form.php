<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\VehicleType;
use common\models\User;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */
/* @var $form yii\widgets\ActiveForm */


$this->registerJs("
    
    $('.on-change-update').on('change', function(e) {
        var target = \$(this).data('target');
        var source = \$(this).data('source');
        if(target != undefined) {
            $(target).html('');
            $(target).append('<option>- Selecciona -</option>');
            $.ajax({
                url: source,
                data: { id: \$(this).val() },
                success: function(response, status) {
                    if(response.success == true) {
                        $.each(response.data, function(i,o) {
                            $(target).append( nano('<option value=\"{o.id}\">{o.label}</option>', { o: o}) );
                        });
                    }
                },
                complete: function() {
                    $(target).val( {$model->default_operator_id} );
                }
            });
        }
    });

    $('#vehicle-vehicle_type_id').change();

", View::POS_READY);


?>

<div class="vehicle-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-4"><?= $form->field($model, 'status')->dropDownList($model->status_options) ?></div>

    <div class="col-sm-4"><?= $form->field($model, 'vehicle_type_id', [
        'inputOptions' => [
            'class' => 'on-change-update form-control',
            'data-source' => Url::to(['vehicle/get-operators']),
            'data-target' => "#vehicle-default_operator_id",
        ]
    ])->dropDownList(VehicleType::getListData()) ?></div>

    <div class="col-sm-4"><?= $form->field($model, 'plate')->textInput(['maxlength' => true]) ?></div>

    <div class="col-sm-4"><?= $form->field($model, 'model')->textInput() ?></div>

    <div class="col-sm-4"><?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?></div>

<div class="col-sm-4"><?= $form->field($model, 'default_operator_id')->dropDownList([], ['prompt' => '- Ninguno -']) ?></div>

    
    <div class="text-right">        
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

