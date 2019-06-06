<?php

use yii\helpers\Html;
use backend\assets\ThemeAsset;
$assets = ThemeAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Modificar ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Operadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="user-update">

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
			<div class="x_title" style="overflow: auto;"><h2>Actualizar información del operador</h2></div>
			<div class="x_content">
				<?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
			</div>
		</div>
	</div>
</div>
