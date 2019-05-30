<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Config;

/* @var $this yii\web\View */
/* @var $model common\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $model->translateContent(); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="text-right">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
