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

    <?= $form->field($model, 'status')->dropDownList($model->status_options) ?>

    <?= $form->field($model, 'vehicle_type_id')->dropDownList(VehicleType::getListData()) ?>

    <?= $form->field($model, 'plate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textInput() ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'default_operator_id')->dropDownList(User::getListData(User::TYPE_OPERATOR), ['prompt' => '- Ninguno -']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
