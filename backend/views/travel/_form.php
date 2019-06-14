<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Service;
use common\models\Zone;
use common\models\Client;
use common\models\VehicleType;
use common\models\Travel;
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
                // console.log( found );
                
                $('#travelform-from_zone_id').val( found.id );
                $('#travelform-from_location').val( location.lat() + ',' + location.lng() );
                $('#from_zone').val( found.name );

                marker_from.setPosition(location);
                map_from.setCenter(location);
                map_from.setZoom(16);
                
            } else {
                // console.log( 'Not found' );

                $('#travelform-from_zone_id').val('');
                $('#travelform-from_location').val('');
                $('#from_zone').val('');
            }

            $('#travelform-from_zone_id').change();
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
                // console.log( found2 );

                $('#travelform-to_zone_id').val( found2.id );
                $('#travelform-to_location').val( location2.lat() + ',' + location2.lng() );
                $('#to_zone').val( found2.name );

                marker_to.setPosition(location);
                map_to.setCenter(location);
                map_to.setZoom(16);

            } else {
                // console.log( 'Not found' );

                $('#travelform-to_zone_id').val('');
                $('#travelform-to_location').val('');
                $('#to_zone').val('');
            }

            $('#travelform-to_zone_id').change();
        });

    }

    initMap();


", View::POS_READY);

$this->registerJs("

    function updateTotal() {
        updateSummary();

        $('#Summary').block({ message: '<div style=\'padding: 0.5em 1em;\'><b><small>Cotizando...</small></b></div>' }); 
        $.ajax({
            url: '".Url::to(['/travel/quote'])."',
            method: 'post',
            dataType: 'json',
            data: $('#travel-form').serializeArray(),
            success: function(result) {
                
                if(result.success == true) {
                    $('#Summary .subtotal').html( result.data.subtotal );
                    $('#Summary .service').html( result.data.service );
                    $('#Summary .additionals').html( result.data.additionals );
                    $('#Summary .total').html( result.data.total );

                    $('.total-container').removeClass('d-none');
                    $('.total-error-container').addClass('d-none');
                } else {
                    $('.total-container').addClass('d-none');
                    $('.total-error-container').removeClass('d-none');
                }
            }, 
            complete: function(status) {
                $('#Summary').unblock();
            }
        });
    }


    function updateSummary() {

        // Cliente
        $('#Summary .client-name').html( nano('<span>{content}</span>', { 
            content: $('#travelform-client_id option:selected').text() 
        }) );

        // Vehiculos 
    
        var vehicles = [];
        var vehicles_names = [];
        $.each( $('.vehicle-type-field'), function(i,o) {
        
            if( vehicles[ $(o).val() ] == undefined ) {
                vehicles[ $(o).val() ] = 0;                
            }

            vehicles[ $(o).val() ] += 1;
            vehicles_names[ $(o).val() ] = $('#' + $(o).attr('id') + ' option:selected').text();
            
        });

        $('#Summary .vehicles').html('');
        $.each(vehicles_names, function(i,o) {
            
            if(vehicles_names[i] != undefined && vehicles_names[i].length != 0) {
                $('#Summary .vehicles').append(nano('<span>{qty} x {name}</span>', {
                    qty: vehicles[i],
                    name: vehicles_names[i]   
                }));
            }

        });

        if( vehicles_names.length == 0 ) {
            $('#Summary .vehicles').html('<span>No configurado</span>');
        }

        // Pasajeros

        var passangers = { adults: 0, children: 0 };

        $.each( $('.passangers-field'), function(i,o) {
        
            var p = 0;
            if( $(o).val().length != 0 ) {
                p =  parseInt( $(o).val() );
            }
            
            if($(o).data('type') == 'adults') {
                passangers.adults +=  p;
            } else {
                passangers.children += p;
            }

        });

        $('#Summary .passangers').html( nano('{adults} Adultos, {children} menores', passangers) );

        // Tipo Servicio
        // $('#Summary .service-type').html( nano('<span>{content}</span>', { 
        //     content: $('#travelform-type option:selected').text() 
        // }) );

        // if( $('#travelform-type').val() == ".Travel::TYPE_SPECIAL.") {

        //     $('#Summary .origin-destination-container').addClass('d-none');
        //     $('#Summary .time-container').removeClass('d-none');

        //     var date = $('#travelform-date').val();
        //     var from = $('#travelform-pickup').val();
        //     var to = $('#travelform-dropoff').val();
            
        //     if(date.length != 0 && from.length != 0 && to.length != 0) {
        //         $('#Summary .time').html( nano('<span>{date} {from} a {to}</span>', {
        //             date: date,
        //             from: from,
        //             to: to
        //         }) );    
        //     } else {
        //         $('#Summary .time').html( nano('<span>No configurado</span>') );
        //     }

        //  } else {

        //     $('#Summary .origin-destination-container').removeClass('d-none');
        //     $('#Summary .time-container').addClass('d-none');
                
        //     var from_zone = $('#from_zone').val();
        //     var to_zone = $('#to_zone').val();

        //     // console.log('from_zone', from_zone);
        //     // console.log('to_zone', to_zone);

        //     if(from_zone.length != 0 && to_zone.length != 0) {
        //         $('#Summary .origin-destination').html( nano('<span>{from} a {to}</span>', {
        //             from: from,
        //             to: to
        //         }) );    
        //     } else {
        //         $('#Summary .origin-destination').html( nano('<span>No configurado</span>') );    
        //     }
            
        //  }
    }

    function bindVehiclesEvents(context) {

        $(context + ' .vehicle-type-field').unbind('change');
        $(context + ' .vehicle-type-field').on('change', function(e) {
            var suffix_id = $(this).data('suffix_id');
            
            $.ajax({
                url: '" . Url::to(['/travel/get-vehicle-type']) . "',
                dataType: 'json',
                data: { id : $(this).val() }
            })
            .done(function(result) {

                if(result.success == true) {
                    // console.log(result.data);
                    $('#travelvehicle-vehicle_type_id_' + suffix_id).data('max_passangers', result.data.max_passangers);
                    $('#travelvehicle-vehicle_type_id_' + suffix_id).data('max_bags', result.data.max_bags);

                    // $('#travelvehicle-adults_' + suffix_id).val( result.data.max_passangers );
                    // $('#travelvehicle-children_' + suffix_id).val( 0 );
                    // $('#travelvehicle-bags_' + suffix_id).val( result.data.max_bags );

                    $('#travelvehicle-vehicle_id_' + suffix_id).html('<option value=\"\">- Sin asignar -</option>');
                    $.each(result.data.vehicles, function(i,o) {
                        $('#travelvehicle-vehicle_id_' + suffix_id)
                            .append( nano('<option value=\"{o.id}\">{o.label}</option>', { o: o }) );
                    });

                    $('#travelvehicle-operator_id' + suffix_id).html('<option value=\"\">- Sin asignar -</option>');
                    $.each(result.data.operators, function(i,o) {
                        $('#travelvehicle-operator_id_' + suffix_id)
                            .append( nano('<option value=\"{o.id}\">{o.label}</option>', { o: o }) );
                    });
                }

            })
            .always(function(status) { updateTotal(); });
        });
        
        $(context + ' .passangers-field').unbind('change');
        $(context + ' .passangers-field').on('change', function(e) {

            var suffix_id = $(this).data('suffix_id');

            var max = parseInt( $('#travelvehicle-vehicle_type_id_' + suffix_id).data('max_passangers') );
            var adults = parseInt( $('#travelvehicle-adults_' + suffix_id).val() );
            var children = parseInt( $('#travelvehicle-children_' + suffix_id).val() );
            var passangers = adults + children;


            if( passangers > max  ) {
                // $(this).val( Math.abs(parseInt($(this).val()) - (passangers - max)) );
                alert('Superas el máximo de pasajeros permitidos: ' + max);
            }

            // updateTotal();
        });

        $(context + ' .bags-field').unbind('change');
        $(context + ' .bags-field').on('change', function(e) {

            var suffix_id = $(this).data('suffix_id');

            var max = parseInt( $('#travelvehicle-vehicle_type_id_' + suffix_id).data('max_bags') );
            var bags = parseInt( $('#travelvehicle-bags_' + suffix_id).val() );

            // console.log('max', max);
            // console.log('bags', bags);

            if( bags > max  ) {
                // $(this).val( Math.abs(parseInt($(this).val()) - (passangers - max)) );
                alert('Superas el máximo de maletas permitidas: ' + max);
            }

            updateTotal();
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

    $('#Summary').followWhen(185);

    $('.summary-update').on('change', function(e) {
        updateTotal();
    });

    updateTotal();

", View::POS_READY);

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
                    'class' => 'form-control vehicle-type-field',
                    'name' => 'TravelVehicleForm[{{id}}][vehicle_type_id]',
                    'id' => sprintf('%s_{{id}}', Html::getInputId($tvModel, 'vehicle_type_id')),
                    'data-suffix_id' => '{{id}}',
                ]); ?></td>
        <td><?= Html::activeTextInput($tvModel, 'adults', [ 
                    'placeholder' => '0',
                    'class' => 'form-control passangers-field',
                    'name' => 'TravelVehicleForm[{{id}}][adults]',
                    'id' => sprintf('%s_{{id}}', Html::getInputId($tvModel, 'adults')),
                    'data-suffix_id' => '{{id}}',
                    'data-type' => 'adults',
                ]); ?></td>
        <td><?= Html::activeTextInput($tvModel, 'children', [ 
                    'placeholder' => '0',
                    'class' => 'form-control passangers-field',
                    'name' => 'TravelVehicleForm[{{id}}][children]',
                    'id' => sprintf('%s_{{id}}', Html::getInputId($tvModel, 'children')),
                    'data-suffix_id' => '{{id}}',
                    'data-type' => 'children',
                ]); ?></td>
        <td><?= Html::activeTextInput($tvModel, 'bags', [ 
                    'placeholder' => '0',
                    'class' => 'form-control bags-field',
                    'name' => 'TravelVehicleForm[{{id}}][bags]',
                    'id' => sprintf('%s_{{id}}', Html::getInputId($tvModel, 'bags')),
                    'data-suffix_id' => '{{id}}',
                ]); ?></td>
        <td><?= Html::activeDropDownList($tvModel, 'vehicle_id', [], [ 
                    'prompt' => '- Selecciona -',
                    'class' => 'form-control',
                    'name' => 'TravelVehicleForm[{{id}}][vehicle_id]',
                    'id' => sprintf('%s_{{id}}', Html::getInputId($tvModel, 'vehicle_id')),
                    'data-suffix_id' => '{{id}}',
                ]); ?></td>
        <td><?= Html::activeDropDownList($tvModel, 'operator_id', [], [ 
                    'prompt' => '- Selecciona -',
                    'id' => sprintf('%s_{{id}}', Html::getInputId($tvModel, 'operator_id')),
                    // 'id' => "operator_id_{{id}}",
                    'class' => 'form-control',
                    'name' => 'TravelVehicleForm[{{id}}][operator_id]',
                    'data-suffix_id' => '{{id}}',
                ]); ?></td>                               
    </tr>
</script>


<?php $form = ActiveForm::begin(['id' => 'travel-form']); ?>
<div class="travel-form">
    <div class="col-xs-9">

        
        <p class="lead">Información general</p>
        
        <div class="row">
            
            <div class="col-sm-6">
                <?= $form->field($model, 'client_id', ['inputOptions' => ['class' => 'form-control summary-update']])->dropDownList(Client::getListData()) ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'type', ['inputOptions' => ['class' => 'form-control summary-update']])->dropDownList($model->type_options) ?>
                <label for="" class="d-none">
                    <?= Html::checkBox('previous_travel'); ?> Es un servicio enlazado.
                </label>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'service_id', ['inputOptions' => ['class' => 'form-control summary-update']])->dropDownList(Service::getListData()) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'date', ['inputOptions' => ['class' => 'form-control summary-update']])->widget(\yii\jui\DatePicker::class, [
                    'language' => 'es',
                    'dateFormat' => 'dd/MM/yyyy',
                    'options' => [
                        'class' => 'form-control summary-update',
                    ]
                ]) ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'pickup', [
                    'inputOptions' => ['class' => 'form-control clockpicker summary-update'],
                ])->textInput() ?>
            </div>

             <div class="col-sm-3 dependant"
                data-field="#travelform-type"
                data-action="show"
                data-value="<?= Travel::TYPE_SPECIAL; ?>">
                <?= $form->field($model, 'dropoff', [
                    'inputOptions' => ['class' => 'form-control clockpicker summary-update'],
                ])->textInput() ?>
            </div>
        </div>

        <br>
        <p class="lead">Vehículos</p>

        <div class="row">
            <div class="col-sm-12">

                <div class="text-right">
                    <button
                        class="btn btn-info add-vehicle">
                        <i class="fa fa-plus"></i> Agregar vehículo
                    </button>
                </div>
                <div id="vehicles-app">
                    <table id="vehicles-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tipo de vehículo</th>
                                <th width="80">Adultos</th>
                                <th width="80">Menores</th>
                                <th width="80">Maletas</th>
                                <th>Vehículo</th>
                                <th>Operador</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( !$travel->isNewRecord ): ?>
                                <?php foreach($travel->vehicles as $vehicle): ?>
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
                                                    'class' => 'form-control vehicle-type-field',
                                                    'name' => "TravelVehicle[{$vehicle->id}][vehicle_type_id]",
                                                    'id' => sprintf('%s_%d', Html::getInputId($vehicle, 'vehicle_type_id'), $vehicle->id),
                                                    'data-suffix_id' => $vehicle->id,
                                                ]); ?></td>
                                        <td><?= Html::activeTextInput($vehicle, 'adults', [ 
                                                'placeholder' => '0',
                                                'class' => 'form-control passangers-field',
                                                'name' => "TravelVehicle[{$vehicle->id}][adults]",
                                                'id' => sprintf('%s_%d', Html::getInputId($vehicle, 'adults'), $vehicle->id),
                                                'data-suffix_id' => $vehicle->id,
                                                'data-type' => 'adults',
                                            ]); ?></td>
                                        <td><?= Html::activeTextInput($vehicle, 'children', [ 
                                                'placeholder' => '0',
                                                'class' => 'form-control passangers-field',
                                                'name' => "TravelVehicle[{$vehicle->id}][children]",
                                                'id' => sprintf('%s_%d', Html::getInputId($vehicle, 'children'), $vehicle->id),
                                                'data-suffix_id' => $vehicle->id,
                                                'data-type' => 'children',
                                            ]); ?></td>
                                        <td><?= Html::activeTextInput($vehicle, 'bags', [ 
                                                'placeholder' => '0',
                                                'class' => 'form-control bags-field',
                                                'name' => "TravelVehicle[{$vehicle->id}][bags]",
                                                'id' => sprintf('%s_%d', Html::getInputId($vehicle, 'bags'), $vehicle->id),
                                                'data-suffix_id' => $vehicle->id,
                                            ]); ?></td>
                                        <td><?= Html::activeDropDownList($vehicle, 'vehicle_id', [], [ 
                                                    'prompt' => '- Selecciona -',
                                                    'class' => 'form-control',
                                                    'name' => "TravelVehicle[{$vehicle->id}][vehicle_id]",
                                                    'id' => sprintf('%s_%d', Html::getInputId($vehicle, 'vehicle_id'), $vehicle->id),
                                                    'data-suffix_id' => $vehicle->id,
                                                ]); ?></td>
                                        <td><?= Html::activeDropDownList($vehicle, 'operator_id', [], [ 
                                                    'prompt' => '- Selecciona -',
                                                    'class' => 'form-control',
                                                    'name' => "TravelVehicle[{$vehicle->id}][operator_id]",
                                                    'id' => sprintf('%s_%d', Html::getInputId($vehicle, 'operator_id'), $vehicle->id),
                                                    'data-suffix_id' => $vehicle->id,
                                                ]); ?></td>                                
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                    
                </div>

            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'passanger_name')->textArea(['rows' => 4]) ?>
            </div>
        </div>
        
        <p class="lead">Origen y destino</p>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'from_address')->textInput(['maxlength' => true]) ?>
                <div id="map_from" style="height: 400px;"></div>
                <?= Html::activeHiddenInput($model, 'from_zone_id', [
                    'class' => 'summary-update',
                ]) ?>
                <?= Html::activeHiddenInput($model, 'from_location') ?>
                <?= Html::hiddenInput('from_zone', '', ['id' => 'from_zone']); ?>
            </div>

             <div class="col-sm-12 dependant"
                data-field="#travelform-type"
                data-action="hide"
                data-value="<?= Travel::TYPE_SPECIAL; ?>">
                <br>
                <?= $form->field($model, 'to_address')->textInput(['maxlength' => true]) ?>
                <div id="map_to" style="height: 400px;"></div>
                <?= Html::activeHiddenInput($model, 'to_zone_id', [
                    'class' => 'summary-update',
                ]) ?>
                <?= Html::activeHiddenInput($model, 'to_location') ?>
                <?= Html::hiddenInput('to_zone', '', ['id' => 'to_zone']); ?>
            </div>
        </div>

    </div>
    <div class="col-xs-3"  id="Summary" style="box-shadow: -4px 3px 4px -3px rgba(115,135,156,1); padding-left: 1em; padding-top: 1em; background: #fff;">
        <div class="row">
            
            <div class="content invoice">
                <div class="col-sm-12">
                    <p class="lead">Resumen</p>
                </div>
                <div class="col-sm-12 invoice-col">
                  <address>
                      <div>
                        <b>Cliente: </b> 
                        <div class="client-name">
                            <span>Hotel Aranza</span>    
                        </div>
                      </div>
                      <div>
                        <b>Vehículos: </b>
                        <div class="vehicles">
                            <span>1 x Cadillac Escalade</span>
                            <span>2 x Audi A4</span>
                        </div>
                      </div>
                      <div>
                        <b>Pasajeros: </b>
                        <div class="passangers">
                            <span>2 adultos, 3 menores</span>
                        </div>
                      </div>
<!--                       <div>
                        <b>Adicionales: </b>
                        <div class="aditionals">
                            <span>1 x Silla Baby</span>
                            <span>2 x Silla Niño 8 - 12</span>
                        </div>
                      </div> -->
<!--                       <div>
                        <b>Tipo de servicio: </b>
                        <div class="service-type">
                            <span>Colectivo</span>
                        </div>
                      </div>
                      <div class="origin-destination-container">
                        <b>Zona origen y destino: </b>
                        <div class="origin-destination">
                            <span>Z1 - Z2</span>    
                        </div>
                      </div>
                      <div class="time-container">
                        <b>Tiempo de servicio: </b>
                        <div class="time">
                            <span>01/01/2019 01:00 - 03:00</span>    
                        </div>
                      </div> -->
                  </address>
                </div>
                <div class="col-sm-12">
                  <p class="lead">Total</p>
                  <div class="total-container table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <th style="width:50%">Subtotal:</th>
                          <td class="text-right subtotal" >$ 0.00</td>
                        </tr>
                        <tr>
                          <th>Amenidades</th>
                          <td class="text-right service" >$ 0.00</td>
                        </tr>
                        <tr>
                          <th>Adicionales</th>
                          <td class="text-right additionals" >$ 0.00</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td class="text-right total" >$ 0.00</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="total-error-container d-none">
                      <b>Son necesarios mas datos para cotizar.</b>
                  </div>
                </div>

                <div class="col-sm-12 text-right">
                    <br>
                    <?= Html::submitButton('<i class="fa fa-save"></i> Guardar', ['class' => 'btn btn-success']); ?>
                    <br><br>
                </div>
            </div>
        </div>
    </div>

</div>

<?php ActiveForm::end(); ?>
