<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\VehicleType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_passangers')->textInput() ?>

    <?= $form->field($model, 'max_bags')->textInput() ?>

    <div class="col-sm-12 form-group text-right">
        <div class="ln_solid"></div>
        <?= Html::submitButton('<i class="fa fa-save"></i> Guardar', ['class' => 'btn btn-success']); ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
