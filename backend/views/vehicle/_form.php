<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\VehicleType;
use common\models\User;
/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-4"><?= $form->field($model, 'status')->dropDownList($model->status_options) ?></div>

    <div class="col-sm-4"><?= $form->field($model, 'vehicle_type_id')->dropDownList(VehicleType::getListData()) ?></div>

    <div class="col-sm-4"><?= $form->field($model, 'plate')->textInput(['maxlength' => true]) ?></div>

    <div class="col-sm-4"><?= $form->field($model, 'model')->textInput() ?></div>

    <div class="col-sm-4"><?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?></div>

    <div class="col-sm-4"><?= $form->field($model, 'default_operator_id')->dropDownList(User::getListData(User::TYPE_OPERATOR), ['prompt' => '- Ninguno -']) ?></div>

    
    <div class="text-right">        
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

