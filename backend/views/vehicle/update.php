<?php

use yii\helpers\Html;
use backend\assets\ThemeAsset;
$assets = ThemeAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */


$this->title = Yii::t('app', 'Modificar: ') . $model->getFormatted('plate');
$this->params['breadcrumbs'][] = ['label' => 'Vehículos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->plate];
?>
<div class="vehicle-update">
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
			<div class="x_title"><h5>Información general</h5></div>
			<div class="x_content">
				<?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="x_panel">
				<div class="x_title"><h5>Administrar tarifas por hora</h5></div>
				<div class="x_content">
					<?= $this->render('_rate_form', [
				        'model' => $model,
				    ]) ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="x_panel">
				<div class="x_title"><h5>Administrar tarifas por zona</h5></div>
				<div class="x_content">
					<?= $this->render('_zone_rate_form', [
				        'model' => $model,
				    ]) ?>
				</div>
			</div>
		</div>
	</div>
</div>
