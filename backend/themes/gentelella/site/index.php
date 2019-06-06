<?php

/**
 * @var $this yii\web\View
 * @var $name string
 * @var $message string
 * @var $exception \yii\web\HttpException
 */

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\JSON;
use common\models\Zone;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;

$this->title = 'Index';

/* @var $this yii\web\View */
/* @var $model common\models\Zone */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyAZZj-ayn0lracynja85xIx3fUzcOwMWjc&libraries=places');

foreach(Zone::find()->all() as $zone) {
	$pol = $zone->getFormatted('polygon');
	$polygons[] = "polygons.push( { id: {$zone->id}, name: '{$zone->name}', polygon: new google.maps.Polygon({ paths: {$pol} }) } );";
}

$polygons = implode('', $polygons);
$this->registerJs("

	var polygons = [];
	{$polygons}

	function initMap()
	{
		var input = document.getElementById('quotationform-from');
		var autocomplete = new google.maps.places.Autocomplete(input);
		autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        autocomplete.addListener('place_changed', function() {
			var place = autocomplete.getPlace();
			var location = place.geometry.location;
			
			var found = false;
			for(var i=0;i<polygons.length;i++) {
				if( google.maps.geometry.poly.containsLocation(location, polygons[i].polygon)  ) {
					found = polygons[i];
					break;
				}
			}

			if( found != false ) {
				console.log( found );
				$('#from-help').html( 'Zona: ' + found.name );
				$('#quotationform-from_point').val( location.lat() + ',' + location.lng() );
			} else {
				console.log( 'Not found' );
			}
        });

        // ---

		var input2 = document.getElementById('quotationform-to');
		var autocomplete2 = new google.maps.places.Autocomplete(input2);
		autocomplete2.setFields(['address_components', 'geometry', 'icon', 'name']);

        autocomplete2.addListener('place_changed', function() {
			var place2 = autocomplete2.getPlace();
			var location2 = place2.geometry.location;
			
			var found2 = false;
			for(var i=0;i<polygons.length;i++) {
				if( google.maps.geometry.poly.containsLocation(location2, polygons[i].polygon)  ) {
					found2 = polygons[i];
					break;
				}
			}

			if( found2 != false ) {
				console.log( found2 );
				$('#to-help').html( 'Zona: ' + found2.name );
				$('#quotationform-to_point').val( location2.lat() + ',' + location2.lng() );
			} else {
				console.log( 'Not found' );
			}
        });

	}

	initMap();


", View::POS_READY);
?>

<div class="col-middle">
    <div class="text-left">

    	<div class="row">
    		<div class="col-sm-6">
		        <h2>Cotizar</h2>

		        <?php $form = ActiveForm::begin(['id' => 'quoation-form']); ?>

		            <?= $form->field($model, 'from')->textInput(['autofocus' => true]) ?>
		            <p class="help-text" id="from-help"></p>

		            <?= $form->field($model, 'to')->textInput(['autofocus' => true]) ?>
		            <p class="help-text" id="to-help"></p>

		            <?= Html::activeHiddenInput($model, 'from_point'); ?>
		            <?= Html::activeHiddenInput($model, 'to_point'); ?>

		            <div class="form-group text-right">
		            	<br>
		                <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'contact-button']) ?>
		            </div>

		        <?php ActiveForm::end(); ?>	
    		</div>
    	</div>
    </div>
</div>
