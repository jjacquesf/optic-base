<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\VehicleType;
?><?php //$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
	<br>
	<?php foreach(VehicleType::find()->all() as $vt): ?>
		<div class="form-group">
			<label class="control-label col-md-6 col-sm-6 col-xs-12"><?= $vt->name; ?></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<?= Html::textInput("VehicleTypeRate[{$vt->id}]", $model->getVehicleTypeRate($vt->id), [
					'class' => 'form-control'
				]); ?>
			</div>
		</div>
	<?php endforeach; ?>
<?php //ActiveForm::end(); ?>