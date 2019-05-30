<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Zone;
use common\models\VehicleType;
?><?php //$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
	<br>
	<?php foreach(Zone::getCross() as $route): ?>
		<h5><?= sprintf('%s - %s', $route['z1']->name, $route['z2']->name); ?></h5>
		<?php foreach(VehicleType::find()->all() as $vt): ?>
			<div class="form-group">
				<label class="control-label col-md-6 col-sm-6 col-xs-12"><?= $vt->name; ?></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<?= Html::textInput(sprintf('%s[%d]', $route['field_name'], $vt->id), $model->getVehicleTypeZoneRate($route['z1']->id, $route['z2']->id, $vt->id), [
						'class' => 'form-control'
					]); ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endforeach; ?>
<?php //ActiveForm::end(); ?>