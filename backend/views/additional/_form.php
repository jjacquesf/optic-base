<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Additional */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="additional-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $model->translateContent(); ?>
	
    <div class="col-sm-4 form-group">
    	<?= $form->field($model, 'price')->textInput() ?>
    </div>

    <div class="col-sm-4 form-group">
    	<?= $form->field($model, 'qty')->textInput() ?>
    </div>    

    <div class="col-sm-12 form-group text-right">
        <div class="ln_solid"></div>
        <?= Html::submitButton('<i class="fa fa-save"></i> Guardar', ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
