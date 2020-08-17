<?php
use frontend\assets\ThemeAsset;
use yii\web\View;
use common\models\Zone;
use common\models\Additional;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use frontend\models\SearchTravelForm;
use yii\widgets\ActiveForm;

$assets = ThemeAsset::register($this);

$searchForm = new SearchTravelForm();

$polygons = [];
foreach(Zone::find()->all() as $zone) {
    $pol = $zone->getFormatted('polygon');
    $polygons[] = "polygons.push( { id: {$zone->id}, name: '{$zone->name}', polygon: new google.maps.Polygon({ paths: {$pol} }) } );";
}
$polygons = implode("\n", $polygons);
$lang = Yii::$app->language;

$quote_url = Url::to(['/site/quote']);
$book_url = Url::to(['/site/book']);


$additional_options = Json::encode(Additional::getListData(), true);
$additionals = []; 
$additionals_prices = []; 
foreach(Additional::getList() as $additional) {
    $additionals[$additional->id] = 0;
    $additionals_prices[$additional->id] = $additional->price;
}
$additional_fields = Json::encode($additionals);
$additional_prices = Json::encode($additionals_prices);

// var_dump(Json::encode(Additional::getListData()));
// var_dump($additionals);
// var_dump($additional_prices); die();

$this->registerJsFile("//maps.googleapis.com/maps/api/js?key=AIzaSyAZZj-ayn0lracynja85xIx3fUzcOwMWjc&libraries=places,geometry&language={$lang}");
$this->registerJsFile('https://cdn.jsdelivr.net/npm/vue');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/vuelidate@0.7.4/dist/vuelidate.min.js');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/vuelidate@0.7.4/dist/validators.min.js');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/es.js');
$this->registerJs("
    Vue.use(window.vuelidate.default)
    const { required, minLength, integer, minValue } = window.validators
    var app = new Vue({
        el: '#booking-app',
        data: {
            // general
            step: 1,
            submit_status: null,
            quote: null,
            quotes: [],
            additional_options: {$additional_options},
            additional_prices: {$additional_prices},

            // step 1 form
            pickup_date: '".date('d/m/Y', strtotime('tomorrow'))."',
            pickup_time: '13:00',
            service_id: '',
            additionals: {$additional_fields},

            from_address: '',            
            from_zone: '',
            from_location: '',
            from_zone_id: 0,

            to_address: '',            
            to_zone: '',
            to_location: '',
            to_zone_id: 0,

            adults: 2,
            children: 0,
            infants: 0,
            bags: 2,
            client_name: '',
            client_email: '',
            client_phone: '',
            client_comments: '',
            booking_reference: '',
            booking_total: 0,
        },
        validations: {
            from_location: {
                required
            },
            from_address: {
                required
            },
            from_zone: {
                required
            },
            from_zone_id: {
                required,
                integer,
                minValue: minValue(1)
            },
            to_location: {
                required
            },
            to_address: {
                required
            },
            to_zone: {
                required
            },
            to_zone_id: {
                required,
                integer,
                minValue: minValue(1)
            },
            pickup_date: {
                required
            },
            pickup_time: {
                
            },
            adults: {
                required,
                integer,
                minValue: minValue(1)
            },
            children: {
                integer,
                minValue: minValue(0)
            },
            infants: {
                integer,
                minValue: minValue(0)
            },
            bags: {},
            roundtrip: {},
            additionals: {},
            client_name: {},
            client_email: {},
            client_phone: {},
            client_comments: {},
            booking_reference: {},
            booking_total: {}
        },
        mounted: function() {

            // this.step = 1;

            var app = this;
            const polygons = [];
            {$polygons}
            
            var defaultBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(22.899857, -110.220852),
                new google.maps.LatLng(23.704526, -109.462100)
            );

            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('travelform-from_address'), { 
                // types: ['establishment'], 
                bounds: defaultBounds,
                strictBounds: true
            });
            autocomplete.setFields(['address_components', 'geometry', 'name']);

            autocomplete.addListener('place_changed', function() {
                var place = this.getPlace();
    
                if (!place.geometry)  {
                    var location = place;
                } else {
                    var location = place.geometry.location;
                }
                                
                var found = false;
                for(var i=0;i<polygons.length;i++) {
                    if( google.maps.geometry.poly.containsLocation(location, polygons[i].polygon)  ) {
                        found = polygons[i];
                        break;
                    }
                }

                if( found != false ) {
                    app.\$v.from_address.\$model = place.name
                    app.\$v.from_zone_id.\$model = found.id;
                    app.\$v.from_location.\$model = location.lat() + ',' + location.lng();
                    app.\$v.from_zone.\$model = found.name;
                } else {
                    app.\$v.from_address.\$model = '';
                    app.\$v.from_location.\$model = '';
                    app.\$v.from_zone.\$model = '';
                    app.\$v.from_zone_id.\$model = 0;
                }
            });

            var autocomplete2 = new google.maps.places.Autocomplete(document.getElementById('travelform-to_address'), { 
                // types: ['establishment'], 
                bounds: defaultBounds,
                strictBounds: true
            });
            autocomplete2.setFields(['address_components', 'geometry', 'name']);

            autocomplete2.addListener('place_changed', function() {
                var place = this.getPlace();
    
                if (!place.geometry)  {
                    var location = place;
                } else {
                    var location = place.geometry.location;
                }
                                
                var found = false;
                for(var i=0;i<polygons.length;i++) {
                    if( google.maps.geometry.poly.containsLocation(location, polygons[i].polygon)  ) {
                        found = polygons[i];
                        break;
                    }
                }

                if( found != false ) {
                    app.\$v.to_address.\$model = place.name
                    app.\$v.to_zone_id.\$model = found.id;
                    app.\$v.to_location.\$model = location.lat() + ',' + location.lng();
                    app.\$v.to_zone.\$model = found.name;
                } else {
                    app.\$v.to_address.\$model = '';
                    app.\$v.to_location.\$model = '';
                    app.\$v.to_zone.\$model = '';
                    app.\$v.to_zone_id.\$model = 0;
                }
            });

        },
        methods: {
            minus(input, min) {
                input.\$model -= 1;
                if(input.\$model < min) { input.\$model = min; }
            },
            plus(input, min) {
                input.\$model += 1;
                if(input.\$model < min) { input.\$model = min; }
            },
            minusv(key, min) {
                this.additionals[key] -= 1;
                if(this.additionals[key] < min) { this.additionals[key] = min; }
            },
            plusv(key, min) {
                this.additionals[key] += 1;
                if(this.additionals[key] < min) { this.additionals[key] = min; }
            },
            formatCurrency(value) {
                var formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });

                return formatter.format(value);
            },
            getSubtotal() {
                return this.quote.price;
            },
            getAdditional() {
                var keys = Object.keys(this.additionals);
                var amount = 0;
                for(var i = 0; i < keys.length; i++) {
                    amount += this.additionals[keys[i]] * this.additional_prices[keys[i]];
                }
                
                return amount;  
            },
            getTotal() {
                return this.getSubtotal() + this.getAdditional();
            },
            submit() {
                var ctrl = this;
                $.ajax({
                    url: '$quote_url',
                    data: $('#step1-form').serializeArray(),
                    success: function(result) {
                        if(result.success == true) {
                            ctrl.quotes = result.data;
                            ctrl.step = 2;
                        }
                    },
                    complete: function(result) {}
                });
            },
            choose(quote) {
                this.quote = quote;
                this.step = 3;
            },
            goToStep(step) {
                this.step = step;
            },
            bookTravel() {
             
                var ctrl = this;
                $.ajax({
                    url: '$book_url',
                    method: 'POST',
                    data: {
                        QuoteForm: {
                            from_address: ctrl.from_address,
                            from_zone: ctrl.from_zone,
                            from_location: ctrl.from_location,
                            from_zone_id: ctrl.from_zone_id,
                            to_address: ctrl.to_address,
                            to_zone: ctrl.to_zone,
                            to_location: ctrl.to_location,
                            to_zone_id: ctrl.to_zone_id,

                            pickup_date: ctrl.pickup_date,
                            pickup_time: ctrl.pickup_time,

                            roundtrip: ctrl.roundtrip,

                            adults: ctrl.adults,
                            children: ctrl.children,
                            infants: ctrl.infants,
                            bags: ctrl.bags,

                            vehicle_type_id: ctrl.quote.vehicle.id,

                            additionals: ctrl.additionals,
                            comments: ctrl.client_comments,
             
                            client_name: ctrl.client_name,
                            client_phone: ctrl.client_phone,
                            client_email: ctrl.client_email
                        }
                    },
                    success: function(result) {
                        if(result.success == true) {
                            // ctrl.step = 5;
                            // ctrl.booking_reference = result.data.reference
                            // ctrl.booking_total = result.data.total
                            window.location.href = '" . Url::to(['/site/travel-detail', 'id' => '']) .  "' + result.data.id;
                        }
                    },
                    complete: function(result) {}
                });
            }
        }
    });

    $('.clockpicker').clockpicker({
        default: 'now',
        autoclose: true,
        donetext: 'Ok'
    });
", View::POS_READY);
?>
<div id="booking-app" class="box-reservation" data-aos="fade-left" data-aos-duration="4000" data-aos-delay="200">
    <div class="box-header"><img src="<?= $assets->baseUrl; ?>/img/LOGO_3_OPTIC.png" alt="Optic"><span>Los Cabos Premium Service</span></div>
    <div class="box-body">
        <div class="reservation-form">
            <form id="step1-form" method="post" @submit.prevent="submit">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group mt-5">
                            <!-- <label class="text-uppercase"><?= Yii::t('app', 'Servicio Privado'); ?></label> -->
                            <button class="form-control choose-destination my-1" v-on:click="goToStep(0)"><i class="fas fa-search"></i><?= Yii::t('app', 'Ya tengo una reservación.') ?><i class="fas end fa-arrow-right"></i></button>
                            <span class="form-control choose-destination"><i class="fas fa-map-marker-alt"></i><?= Yii::t('app', 'Configura tu servicio.') ?><i class="fas end fa-arrow-down"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div 
                            class="form-group" 
                            v-bind:class="{ 'has-error': $v.from_address.$error || $v.from_zone_id.$error || $v.from_zone.$error || $v.from_location.$error, 'has-success': !$v.from_address.$error && !$v.from_zone_id.$error && !$v.from_zone.$error && !$v.from_location.$error  }">
                            <label><?= Yii::t('app', 'Punto de origen'); ?></label>
                            <input 
                                name="from_address"
                                id="travelform-from_address" 
                                v-model="$v.from_address.$model" 
                                class="form-control" 
                                type="text" 
                                placeholder="<?= Yii::t('app', 'Aeropuerto, Hotel, establecimiento...'); ?>">
                            <input v-model="$v.from_zone.$model" name="from_zone" type="hidden">
                            <input v-model="$v.from_location.$model" name="from_location" type="hidden">
                            <input v-model="$v.from_zone_id.$model" name="from_zone_id" type="hidden">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div 
                            class="form-group"
                            v-bind:class="{ 'has-error': $v.to_address.$error || $v.to_zone_id.$error || $v.to_zone.$error || $v.to_location.$error, 'has-success': !$v.to_address.$error && !$v.to_zone_id.$error && !$v.to_zone.$error && !$v.to_location.$error  }">
                            <label><?= Yii::t('app', 'Punto destino'); ?></label>
                            <input 
                                id="travelform-to_address" 
                                name="to_address" 
                                v-model="$v.to_address.$model" 
                                class="form-control" 
                                type="text" 
                                placeholder="<?= Yii::t('app', 'Aeropuerto, Hotel, establecimiento...'); ?>">
                            <input v-model="$v.to_zone.$model" name="to_zone" type="hidden">
                            <input v-model="$v.to_location.$model" name="to_location" type="hidden">
                            <input v-model="$v.to_zone_id.$model" name="to_zone_id" type="hidden">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group mb-0"><label><?= Yii::t('app', 'Adultos'); ?></label></div>
                        <div 
                            class="form-group add-people"
                            v-bind:class="{ 'has-error': $v.adults.$error, 'has-success': !$v.adults.$error  }">
                            <input
                                name="adults" 
                                v-model="$v.adults.$model"
                                class="form-control"
                                type="text"
                                placeholder="<?= Yii::t('app', 'Adultos'); ?>">
                            <button type="button" class="btn btn-default btn-sm" v-on:click="minus($v.adults, 1)"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" v-on:click="plus($v.adults, 1)"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group mb-0"><label><?= Yii::t('app', 'Niños'); ?></label></div>
                        <div 
                            class="form-group add-people"
                            v-bind:class="{ 'has-error': $v.children.$error, 'has-success': !$v.children.$error  }">
                            <input
                                name="children" 
                                v-model="$v.children.$model" 
                                class="form-control"
                                type="text"
                                placeholder="<?= Yii::t('app', 'Niños'); ?>">
                            <button type="button" class="btn btn-default btn-sm" v-on:click="minus($v.children, 0)"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" v-on:click="plus($v.children, 0)"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group mb-0"><label><?= Yii::t('app', 'Bebés'); ?></label></div>
                        <div
                            class="form-group add-people"
                            v-bind:class="{ 'has-error': $v.infants.$error, 'has-success': !$v.infants.$error  }">
                            <input
                                name="infants" 
                                v-model="$v.infants.$model" 
                                class="form-control"
                                type="text"
                                placeholder="<?= Yii::t('app', 'Bebés'); ?>">
                            <button type="button" class="btn btn-default btn-sm" v-on:click="minus($v.infants, 0)"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" v-on:click="plus($v.infants, 0)"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="form-group col-xs-4">
                        <div class="form-group mb-0"><label><?= Yii::t('app', 'Maletas'); ?></label></div>
                            <div
                                class="form-group add-people"
                                v-bind:class="{ 'has-error': $v.bags.$error, 'has-success': !$v.bags.$error  }">
                                <input
                                    name="bags" 
                                    v-model="$v.bags.$model" 
                                    class="form-control"
                                    type="text"
                                    placeholder="<?= Yii::t('app', 'Maletas'); ?>">
                            <button type="button" class="btn btn-default btn-sm" v-on:click="minus($v.bags, 0)"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" v-on:click="plus($v.bags, 0)"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div 
                            class="form-group" 
                            v-bind:class="{ 'has-error': $v.pickup_date.$error, 'has-success': !$v.pickup_date.$error  }">
                            <label><?= Yii::t('app', 'Fecha'); ?></label>
                            <?= yii\jui\DatePicker::widget([
                                        'name'  => 'pickup_date',
                                        'value'  => date('d/m/Y'),
                                        'language' => Yii::$app->language,
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'clientOptions' => [
                                            'minDate' => '+1d',
                                        ],
                                        'options' => [
                                            'v-model' => '$v.pickup_date.$model',
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                        ],
                                    ]); ?>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div 
                            class="form-group" 
                            v-bind:class="{ 'has-error': $v.pickup_time.$error , 'has-success': !$v.pickup_time.$error }">
                            <label><?= Yii::t('app', 'Hora'); ?></label>
                            <input 
                                name="pickup_time" 
                                value="1"
                                v-model="$v.pickup_time.$model" 
                                class="form-control clockpicker" 
                                type="text">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6">
                        <input name="roundtrip" type="checkbox" value="roundtrip">
                        <span><?= Yii::t('app', '¿Viaje redondo?'); ?></span>
                    </div>
                    <div class="form-group col-xs-6 text-right">
                        <input
                            class="btn btn-default text-uppercase"
                            type="submit"
                        value="<?= Yii::t('app', 'Cotizar viaje'); ?>">
                    </div>
                </div>    
            </form>
        </div>
        <div class="m-5" v-if="step == 0">
            <div class="reservation-form">    
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <span class="form-control choose-destination"><i class="fas fa-search"></i><?= Yii::t('app', 'Buscar mi reservación.') ?><i class="fas end fa-arrow-down"></i></span>
                    </div>
                    <div class="col-xs-12">

                        <div class="row">
                        
                            <?php $form = ActiveForm::begin([
                                                'id' => 'search-travel',
                                                'action' => ['/site/travel-search'],
                                  ]); ?>

                                <div class="col-xs-12">
                                    <?= $form->field($searchForm, 'email') ?>
                                </div>

                                <div class="col-xs-12">
                                    <?= $form->field($searchForm, 'reference') ?>
                                </div>

                                <div class="col-xs-12">
                                    <?php /* $form->field($searchForm, 'date')->widget(\yii\jui\DatePicker::classname(), [
                                        // 'language' => 'ru',
                                        'dateFormat' => 'php:d/m/Y',
                                        'options' => [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                        ],
                                    ])*/ ?>
                                </div>

                                <div class="col-xs-6"></div>

                                <div class="form-group col-xs-6 text-right">
                                    <?= Html::submitButton(Yii::t('app', 'Buscar mi viaje'), ['class' => 'btn btn-default text-uppercase', 'name' => 'sarch-button']) ?>
                                </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/banner-reserve.jpg" v-if="step == 1">
        <div class="m-3 step-container" v-if="step == 2 || step == 3 || step == 4 || step == 5">                   
            <div v-if="step == 2">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Vehículo</th>
                            <!-- <th>Max. Pasajeros</th>
                            <th>Max. Maletas</th> -->
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="quote in quotes" v-if="quote.price > 0">
                            <td width="150"><b>{{quote.vehicle.name}}</b>
                                <div>
                                    <small>Max. Pasajeros: {{quote.vehicle.max_passangers}}</small><br>
                                    <small>Max. Maletas: {{quote.vehicle.max_bags}}</small>
                                </div></td>
                            <!-- <td>{{quote.vehicle.max_passangers}}</td>
                            <td>{{quote.vehicle.max_bags}}</td> -->
                            <td><small>{{ formatCurrency(quote.price) }} USD</small></td>
                            <td><button type="button" class="btn btn-sm btn-primary" v-on:click="choose(quote)"><?= Yii::t('app', 'Elegir'); ?></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="step == 3">
                <div class="reservation-form">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Adicional</th>
                            </tr>
                            <tr v-for="(additional, key) in additional_options">
                                <td>
                                    <label>{{additional}}</label>
                                    <div class="form-group mb-0 add-people">    
                                        <input
                                                v-model="additionals[key]" 
                                                class="form-control"
                                                type="text"
                                                placeholder="<?= Yii::t('app', 'Cant.'); ?>">
                                        <button type="button" class="btn btn-default btn-sm" v-on:click="minusv(key, 0)"><i class="fas fa-minus"></i></button>
                                        <button type="button" class="btn btn-default btn-sm" v-on:click="plusv(key, 0)"><i class="fas fa-plus"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th class="text-right"><?= Yii::t('app', 'Vehículo'); ?></th>
                            <td class="text-right">{{ formatCurrency(getSubtotal()) }} USD</td>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app', 'Adicional'); ?></th>
                            <td class="text-right">{{ formatCurrency(getAdditional()) }} USD</td>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app', 'Total'); ?></th>
                            <td class="text-right">{{ formatCurrency(getTotal()) }} USD</td>
                        </tr>
                    </table>
                    <div class="text-left">
                        <button type="button" class="btn btn-default" v-on:click="goToStep(2)"><?= Yii::t('app', 'Atras'); ?></button>
                        <button type="button" class="btn btn-success pull-right" v-on:click="goToStep(4)"><?= Yii::t('app', 'Reservar'); ?></button>
                    </div>
                </div>
            </div>
            <div v-if="step == 4">
                <form id="step4-form" method="post" @submit.prevent="submit">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group mt-5">
                                <label class="text-uppercase"><?= Yii::t('app', 'Servicio Privado'); ?></label>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div 
                                class="form-group"
                                v-bind:class="{ 'has-error': $v.client_name.$error }">
                                <label><?= Yii::t('app', 'Nombre del pasajero'); ?></label>
                                <input 
                                    id="travelform-client_name" 
                                    name="client_name" 
                                    v-model="$v.client_name.$model" 
                                    class="form-control" 
                                    type="text" 
                                    placeholder="Jhon Doe">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div 
                                class="form-group"
                                v-bind:class="{ 'has-error': $v.client_phone.$error }">
                                <label><?= Yii::t('app', 'Teléfono'); ?></label>
                                <input 
                                    id="travelform-client_phone" 
                                    name="client_phone" 
                                    v-model="$v.client_phone.$model" 
                                    class="form-control" 
                                    type="text" 
                                    placeholder="555555555">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div 
                                class="form-group"
                                v-bind:class="{ 'has-error': $v.client_email.$error }">
                                <label><?= Yii::t('app', 'Email'); ?></label>
                                <input 
                                    id="travelform-client_email" 
                                    name="client_email" 
                                    v-model="$v.client_email.$model" 
                                    class="form-control" 
                                    type="text" 
                                    placeholder="jhon@email.com">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div 
                                class="form-group"
                                v-bind:class="{ 'has-error': $v.client_comments.$error }">
                                <label><?= Yii::t('app', 'Cuentanos sobre tu viaje y preferencias'); ?></label>
                                <textarea 
                                    id="travelform-client_comments" 
                                    name="client_comments" 
                                    v-model="$v.client_comments.$model" 
                                    class="form-control" 
                                    type="text" 
                                    placeholder="<?= Yii::t('app', 'Pasajeros, instrucciones específicas, comentarios adicionales, etc'); ?>"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12 text-left">
                            <button type="button" class="btn btn-default" v-on:click="goToStep(3)"><?= Yii::t('app', 'Atras'); ?></button>
                            <button type="button" class="btn btn-success pull-right" v-on:click="bookTravel(3)"><?= Yii::t('app', 'Confirmar'); ?></button>
                        </div>
                    </div>    
                </form>                   
            </div>
            <div v-if="step == 5">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <h4 style="font-size: 1.5em;"><?= Yii::t('app', 'Código de reserva'); ?> {{$v.booking_reference.$model}}</h4>
                                <h3><?= Yii::t('app', 'Realizar pago'); ?></h3>
                            </div>
                        </div>
                        <div class="col-xs-12 text-center">
                            <img src="<?= $assets->baseUrl; ?>/img/paypal.jpg" alt="Paypal" width="200">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12 text-left">
                            
                            <?= Html::beginForm(Yii::$app->paypalEC->getEndPoint(), 'POST', ['id' => 'express-checkout-form']); ?>
                            <?= Html::hiddenInput('business', Yii::$app->paypalEC->business_account); ?>
                            <?= Html::hiddenInput('notify_url', Yii::$app->paypalEC->ipn_url); ?>
                            <?= Html::hiddenInput('cancel_return', Yii::$app->paypalEC->cancel_url); ?>
                            <?= Html::hiddenInput('return', Yii::$app->paypalEC->success_url); ?>
                            <?php // Html::hiddenInput('custom', '{{booking_reference}}'); ?>
                            <input name="custom" v-model="$v.booking_reference.$model" type="hidden">

                            <?= Html::hiddenInput("quantity_1", '1'); ?>
                            <?php // Html::hiddenInput("item_name_1", Yii::t('app', 'Reservación') . ' {{booking_reference}}'); ?>
                            <?php //Html::hiddenInput("amount_1", '{{booking_total}}'); ?>
                            <input name="item_name_1" v-model="$v.booking_reference.$model" type="hidden">
                            <input name="amount_1" v-model="$v.booking_total.$model" type="hidden">

                            <?= Html::hiddenInput('discount_amount_cart', '0.00'); ?>
                            <?= Html::hiddenInput('currency_code', Yii::$app->paypalEC->currency_code); ?>
                            <?= Html::hiddenInput('charset', 'utf-8'); ?>
                            <?= Html::hiddenInput('cmd', '_cart'); ?>
                            <?= Html::hiddenInput('upload', '1'); ?>

                            <button type="submit" class="btn btn-success btn-block"><?= Yii::t('app', 'Pagar ahora'); ?></button>
                            <?= Html::endForm(); ?>
                            
                        </div>
                    </div>                 
            </div>
        </div>
    </div>
</div>