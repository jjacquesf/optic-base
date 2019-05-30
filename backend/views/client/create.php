<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Rate;
use backend\assets\ThemeAsset;

$assets = ThemeAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = Yii::t('app', 'Agregar cliente');
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">

	<div class="page-title">
		<div class="title_left">
			<h3><?= Html::encode($this->title) ?></h3>
		</div>
		<div class="title_right text-right">
			<?= Html::a('<i class="fa fa-chevron-left"></i> Regresar', 'javascript:history.back();', ['btn btn-link']); ?>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="row">
		<div class="x_panel">
			<div class="x_title"></div>
			<div class="x_content">
				
				<div class="client-form">

				    <?php $form = ActiveForm::begin(); ?>
						
						<div class="row">
							<div class="col-sm-4">
								<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
							</div>
							<div class="col-sm-4">
								<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
							</div>
							<div class="col-sm-4">
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
					    
					    <div class="form-group text-right">
					        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
					    </div>

				    <?php ActiveForm::end(); ?>

				</div>

			</div>
		</div>
	</div>

</div>
