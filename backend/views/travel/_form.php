<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Service;
use common\models\Zone;
use common\models\Client;
use common\models\VehicleType;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\Travel */
/* @var $form yii\widgets\ActiveForm */

// var_dump($model); die();

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
        var center = new google.maps.LatLng({lat: 22.927291, lng: -109.942837}); 

        var map_from = new google.maps.Map(document.getElementById('map_from'), {
          center: center,
          zoom: 12
        });

        var map_to = new google.maps.Map(document.getElementById('map_to'), {
          center: center,
          zoom: 12
        });

        var marker_from = new google.maps.Marker({
            position: center,
            map: map_from,
            draggable: true,
            title: 'Punto de origen'
        });

        var marker_to = new google.maps.Marker({
            position: center,
            map: map_to,
            draggable: true,
            title: 'Punto de destino'
        });

        var input = document.getElementById('travelform-from_address');
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
                marker_from.setPosition(location);
                map_from.setCenter(location);
                map_from.setZoom(16);
                $('#travelform-from_zone_id').val( found.id );
                $('#travelform-from_location').val( location.lat() + ',' + location.lng() );
            } else {
                console.log( 'Not found' );
            }
        });

        // ---

        var input2 = document.getElementById('travelform-to_address');
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
                marker_to.setPosition(location);
                map_to.setCenter(location);
                map_to.setZoom(16);
                $('#travelform-to_zone_id').val( found2.id );
                $('#travelform-to_location').val( location2.lat() + ',' + location2.lng() );
            } else {
                console.log( 'Not found' );
            }
        });

    }

    initMap();


", View::POS_READY);

$this->registerJs("

    function bindVehiclesEvents(context) {

        console.log( context + ' .on-change-update' );
   
        $(context + ' .on-change-update').on('change', function(e) {
            var target = \$(this).data('target');
            var source = \$(this).data('source');
            if(target != undefined) {
                $(target).html('');
                $(target).append('<option value=\'\'>- Selecciona -</option>');
                $.ajax({
                    url: source,
                    data: { id: \$(this).val() },
                    success: function(response, status) {
                        if(response.success == true) {
                            $.each(response.data, function(i,o) {
                                $(target).append( nano('<option value=\"{o.id}\">{o.label}</option>', { o: o}) );
                            });
                        }
                    }
                });
            }
        });
    }

    $('.add-vehicle').on('click', function(e) {
        
        e.preventDefault();

        var tpl = \$('#vehicle-tpl').html();
        Mustache.parse(tpl);

        id = 'new_' + Math.floor(Math.random() * (100 - 0) + 0);
        var rendered = Mustache.render(tpl, {id: id});

        \$('#vehicles-table tbody').append(rendered);
        
        bindVehiclesEvents( '#vehicles-table tbody tr#' + id );

    });

    bindVehiclesEvents('#vehicles-table tbody');

", View::POS_READY);

$this->registerJs('

    $(".timepicker").timepicker({
        timeFormat: "H:mm",
        interval: 5,
        minTime: "0",
        maxTime: "6:00pm",
        defaultTime: "14",
        startTime: "10:00",
        dynamic: false,
        dropdown: false,
        scrollbar: true
    }); 

', View::POS_READY);

?>
<script id="vehicle-tpl" type="x-tmpl-mustache">
    <tr id="{{id}}">
        <td class="text-center">
            <button
                class="btn btn-danger delete-vehicle"
                data-id="{{id}}">
                <i class="fa fa-trash"></i>
            </button>
        </td>
        <td><?= Html::activeDropDownList($tvModel, 'vehicle_type_id', VehicleType::getListData(), [ 
                    'prompt' => '- Selecciona -',
                    'class' => 'form-control on-change-update',
                    'name' => 'TravelVehicleForm[{{id}}][vehicle_type_id]',
                    'data-source' => Url::to(['travel/get-vehicles']),
                    'data-target' => "#vehicle_type_id_{{id}}",
                ]); ?></td>
        <td><?= Html::activeDropDownList($tvModel, 'vehicle_id', [], [ 
                    'prompt' => '- Selecciona -',
                    'class' => 'form-control on-change-update',
                    'name' => 'TravelVehicleForm[{{id}}][vehicle_id]',
                    'id' => "vehicle_type_id_{{id}}",
                    'data-source' => Url::to(['travel/get-operators']),
                    'data-target' => "#operator_id_{{id}}",
                ]); ?></td>
        <td><?= Html::activeDropDownList($tvModel, 'operator_id', [], [ 
                    'prompt' => '- Selecciona -',
                    'id' => "operator_id_{{id}}",
                    'class' => 'form-control',
                    'name' => 'TravelVehicleForm[{{id}}][operator_id]',
                ]); ?></td>                                
    </tr>
</script>


<?php $form = ActiveForm::begin(); ?>
<div class="travel-form">
    <div class="col-xs-9">

        
        <p class="lead">Información general</p>
        
        <div class="row">
            
            <div class="col-sm-6">
                <?= $form->field($model, 'client_id')->dropDownList(Client::getListData()) ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'type')->dropDownList($model->type_options) ?>
                <label for="" class="d-none">
                    <?= Html::checkBox('previous_travel'); ?> Es un servicio enlazado.
                </label>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'service_id')->dropDownList(Service::getListData()) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php //$form->field($model, 'date')->textInput() ?>
                <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [
                    'language' => 'es',
                    'dateFormat' => 'dd/MM/yyyy',
                    'options' => [
                        'class' => 'form-control',
                    ]
                ]) ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'pickup', [
                    'inputOptions' => ['class' => 'form-control timepicker'],
                ])->textInput() ?>
            </div>

            <!-- <div class="col-sm-3">
                <?php /*$form->field($model, 'dropoff', [
                    'inputOptions' => ['class' => 'form-control timepicker'],
                ])->textInput()*/ ?>
            </div> -->
        </div>

        <br>
        <p class="lead">Vehículos</p>

        <div class="row">
            <div class="col-sm-12">

                <div class="text-right">
                    <button
                        class="btn btn-success add-vehicle">
                        <i class="fa fa-plus"></i> Agregar vehículo
                    </button>
                </div>
                <div id="vehicles-app">
                    <table id="vehicles-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tipo de vehículo</th>
                                <th>Vehículo</th>
                                <th>Operador</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( $model->isNewRecord ): ?>
                                <?php foreach($model->vehicles as $vehicle): ?>
                                    <tr class="vehicle-<?= $vehicle->id; ?>">
                                        <td class="text-center">
                                            <button
                                                class="btn btn-danger delete-vehicle"
                                                data-id="<?= $vehicle->id; ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                        <td><?= Html::activeDropDownList($vehicle, 'vehicle_type_id', VehicleType::getListData(), [ 
                                                    'prompt' => '- Selecciona -',
                                                    'class' => 'form-control on-change-update',
                                                    'name' => "TravelVehicle[{$vehicle->id}]",
                                                    'data-source' => Url::to(['travel/get-vehicles']),
                                                    'data-target' => "#vehicle_type_id_{$vehicle->id}",
                                                ]); ?></td>
                                        <td><?= Html::activeDropDownList($vehicle, 'vehicle_id', [], [ 
                                                    'prompt' => '- Selecciona -',
                                                    'class' => 'form-control on-change-update',
                                                    'name' => "TravelVehicle[{$vehicle->id}]",
                                                    'id' => "vehicle_type_id_{$vehicle->id}",
                                                    'data-source' => Url::to(['travel/get-operators']),
                                                    'data-target' => "#operator_id_{$vehicle->id}",
                                                ]); ?></td>
                                        <td><?= Html::activeDropDownList($vehicle, 'operator_id', [], [ 
                                                    'prompt' => '- Selecciona -',
                                                    'id' => "operator_id_{$vehicle->id}",
                                                    'class' => 'form-control',
                                                    'name' => "TravelVehicle[{$vehicle->id}]"
                                                ]); ?></td>                                
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                    
                </div>

            </div>
        </div>

        <p class="lead">Información de pasajeros</p>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'passanger_name')->textArea(['rows' => 4]) ?>
            </div>
        </div>
        
        <p class="lead">Origen y destino</p>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'from_address')->textInput(['maxlength' => true]) ?>
                <div id="map_from" style="height: 350px;"></div>
                <?= Html::activeHiddenInput($model, 'from_zone_id') ?>
                <?= Html::activeHiddenInput($model, 'from_location') ?>
            </div>

            <div class="col-sm-12">
                <br>
                <?= $form->field($model, 'to_address')->textInput(['maxlength' => true]) ?>
                <div id="map_to" style="height: 350px;"></div>
                <?= Html::activeHiddenInput($model, 'to_zone_id') ?>
                <?= Html::activeHiddenInput($model, 'to_location') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-right">
                <br>
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']); ?>
            </div>
        </div>


    </div>
    <div class="col-xs-3">

    </div>

</div>

<?php ActiveForm::end(); ?>
