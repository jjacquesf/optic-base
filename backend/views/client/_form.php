<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Rate;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>
        
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'status')->dropDownList($model->status_options) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>
            
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'rate_id')->dropDownList(Rate::getListData()) ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12 form-group text-right">
                <div class="ln_solid"></div>
                <?= Html::submitButton('<i class="fa fa-save"></i> Guardar', ['class' => 'btn btn-success']); ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>