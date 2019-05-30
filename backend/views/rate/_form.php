<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Rate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rate-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>		
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<h4>Tarifas por zona</h4>
			<?= $this->render('_zone_rate_form', [
					        'model' => $model,
					    ]) ?>
		</div>
		<div class="col-sm-6">
			<h4>Tarifas por hora</h4>
			<?= $this->render('_rate_form', [
					        'model' => $model,
					    ]) ?>
		</div>
	</div>
    

    <div class="text-right">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
