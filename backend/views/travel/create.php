<?php

use yii\helpers\Html;
use backend\assets\ThemeAsset;
$assets = ThemeAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Travel */

$this->title = Yii::t('app', 'Registrar nuevo.');
$this->params['breadcrumbs'][] = ['label' => 'Servicios registrados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="travel-create">

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
			<div class="x_title" style="overflow: auto;"><h2>Asistente para nuevo servicio <small>Complete los pasos indicados</small></h2></div>
			<div class="x_content">

				<?= $this->render('_form', [
						        'model' => $model,
						        'tvModel' => $tvModel,
						        'addModel' => $addModel,
						    ]); ?>
			</div>
		</div>
	</div>

</div>
