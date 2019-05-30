<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\JSON;
use common\models\Zone;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Zone */
/* @var $form yii\widgets\ActiveForm */

$polygon = $model->getFormatted('polygon');
$polygons = [];

foreach(Zone::getPolygonsExcept($model->id) as $pol) {
	$polygons[] = "new google.maps.Polygon({
		  map: map,
		  paths: {$pol},
		  strokeColor: '#000000',
		  strokeOpacity: 0.8,
		  strokeWeight: 1,
		  fillColor: '#000000',
		  fillOpacity: 0.35,
		  editable: false,
		  draggable: false,
		  geodesic: true,
		  zindex: 1
		});";
}

$polygons = implode('', $polygons);

$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyAZZj-ayn0lracynja85xIx3fUzcOwMWjc&libraries=drawing');
$this->registerJs("
	
	function updatePolygonFormField(vertices)
	{
		var bounds = [];
		for (var i =0; i < vertices.getLength(); i++) {
          var xy = vertices.getAt(i);
          bounds.push({ lat: xy.lat(), lng: xy.lng() })
        }

        $('#zone-polygon').val( JSON.stringify(bounds) );
	}

	function initMap() 
	{
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 23.150418, lng: -109.715477},
          zoom: 11
        });

		var redCoords = {$polygon};
		var polygon = new google.maps.Polygon({
		  map: map,
		  paths: redCoords,
		  strokeColor: '#FF0000',
		  strokeOpacity: 0.8,
		  strokeWeight: 1,
		  fillColor: '#FF0000',
		  fillOpacity: 0.35,
		  editable: true,
		  draggable: true,
		  geodesic: true,
		  zindex: 2
		});

		google.maps.event.addListener(polygon.getPath(), 'insert_at', function(e) {
			updatePolygonFormField(polygon.getPath());
		});

		google.maps.event.addListener(polygon.getPath(), 'remove_at', function(e) {
			updatePolygonFormField(polygon.getPath());
		});

		google.maps.event.addListener(polygon.getPath(), 'set_at', function(e) {
			updatePolygonFormField(polygon.getPath());
		});

		polygon.addListener('dragend', function(e) {
			updatePolygonFormField(polygon.getPath());
		});
		
		{$polygons}
	}

	initMap();
", View::POS_READY);
?>

<div class="zone-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<label for="zone-polygon">Define el área</label>
        <?= Html::activeHiddenInput($model, 'polygon'); ?>
        <div id="map" style="width: 100%; height: 400px;"></div>
    </div>	
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
