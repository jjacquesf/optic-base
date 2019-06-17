<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\models\VehicleType;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-sm-4">
			<?= $form->field($model, 'status')->dropDownList($model->status_options) ?>		
		</div>

		<div class="col-sm-4">
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
		</div>

		<div class="col-sm-4">
			<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
		</div>

	</div>
	<div class="row">
		
		<div class="col-sm-4">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
		</div>

		<div class="col-sm-4">
			<?= $form->field($model, 'licence')->textInput(['maxlength' => true]) ?>
		</div>

		<div class="col-sm-4">
			<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
		</div>

	</div>
	<div class="row">
		<div class="col-sm-4">
			<?= $form->field($model, 'freeday')->dropDownList($model->days_options) ?>
		</div>
		<div class="col-sm-4">
			<?= $form->field($model, 'vehicle_types_id')->checkboxList(VehicleType::getListData(), [
				'separator' => '&nbsp;&nbsp;'
			]) ?>
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
