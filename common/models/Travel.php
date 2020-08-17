<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use Moment\Moment;

/**
 * This is the model class for table "{{%travel}}".
 *
 * @property int $id
 * @property int $status
 * @property int $type
 * @property int $payed_status
 * @property int $client_id
 * @property int $user_id
 * @property string $created_at
 * @property int $previous_travel_id
 * @property int $service_id
 * @property int $from_zone_id
 * @property string $from_location
 * @property string $from_address
 * @property int $to_zone_id
 * @property string $to_location
 * @property string $to_address
 * @property string $passanger_name
 * @property string $pickup
 * @property double $total
 * @property double $payed
 * @property double $balance
 */
class Travel extends EActiveRecord
{
    const STATUS_CANCELED = 0;
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_COMPLETE = 3;

    const TYPE_ARRIVAL = 1;
    const TYPE_DEPARTURE = 2;
    const TYPE_SPECIAL = 3;
    const TYPE_COLLECTIVE_ARRIVAL = 4;
    const TYPE_COLLECTIVE_DEPARTURE = 5;

    const PAYED_STATUS_PENDING = 0;
    const PAYED_STATUS_PARTIAL = 1;
    const PAYED_STATUS_COMPLETE = 2;

    const SCENARIO_CREATE = 'create';

    public $status_options = [
        self::STATUS_CANCELED => 'Cancelado',
        self::STATUS_PENDING => 'Próximo',
        self::STATUS_ACTIVE => 'En Servicio',
        self::STATUS_COMPLETE => 'Completa',
    ];

    public $type_options = [
        self::TYPE_ARRIVAL => 'Llegada',
        self::TYPE_DEPARTURE => 'Salida',
        self::TYPE_SPECIAL => 'Especial',
        self::TYPE_COLLECTIVE_ARRIVAL => 'Llegada Colectiva',
        self::TYPE_COLLECTIVE_DEPARTURE => 'Salida Colectiva',
    ];

    public $payed_status_options = [
        self::PAYED_STATUS_PENDING => 'Pendiente de pago',
        self::PAYED_STATUS_PARTIAL => 'Parcial de pago',
        self::PAYED_STATUS_COMPLETE => 'Completo de pago',
    ];

    public $info_contents = [
        self::TYPE_ARRIVAL => [
            [ 'code' => 'FLIGHT', 'content' => '', ],
            [ 'code' => 'ROOM', 'content' => '', ],
            [ 'code' => 'COMMENTS', 'content' => '', ],
        ],
        self::TYPE_DEPARTURE => [
            [ 'code' => 'FLIGHT', 'content' => '', ],
            [ 'code' => 'ROOM', 'content' => '', ],
            [ 'code' => 'COMMENTS', 'content' => '', ],
        ],
        self::TYPE_SPECIAL => [
            [ 'code' => 'COMMENTS', 'content' => '', ],
        ],
        self::TYPE_COLLECTIVE_ARRIVAL => [
            [ 'code' => 'FLIGHTS', 'content' => '', ],
            [ 'code' => 'ROOMS', 'content' => '', ],
            [ 'code' => 'COMMENTS', 'content' => '', ],
        ],
        self::TYPE_COLLECTIVE_DEPARTURE => [
            [ 'code' => 'FLIGHTS', 'content' => '', ],
            [ 'code' => 'ROOMS', 'content' => '', ],
            [ 'code' => 'COMMENTS', 'content' => '', ],
        ],
    ];

    public $airline_options = [
        'Aeroméxico' => 'Aeroméxico',
        'American Airlines' => 'American Airlines',
        'Alaska airlines' => 'Alaska airlines',
        'British airlines' => 'British airlines',
        'Internet' => 'Internet',
        'South west' => 'South west',
        'Volaris' => 'Volaris',
        'Viva aerobús' => 'Viva aerobús',
        'West jet' => 'West jet',
        'Privado' => 'Privado / Private',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%travel}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'type', 'client_id', 'service_id', 'from_zone_id', 'from_location', 'from_address', 'pickup'], 'required'],

            [['status', 'payed_status', 'total', 'payed', 'balance'], 'required', 'on' => self::SCENARIO_CREATE],

            [['to_location', 'to_address', 'passanger_name', 'airline', 'flight'], 'default', 'value' => ''],
            [['to_zone_id'], 'default', 'value' => 0],

            [['status', 'type', 'payed_status', 'client_id', 'user_id', 'previous_travel_id', 'service_id', 'from_zone_id', 'to_zone_id'], 'integer'],
            [['created_at', 'pickup', 'dropoff'], 'safe'],
            [['total', 'payed', 'balance'], 'number'],
            [['from_location', 'from_address', 'to_location', 'to_address', 'passanger_name'], 'string', 'max' => 255],
            [['airline', 'flight'], 'string', 'max' => 255],
            ['created_at', 'default', 'value' => new Expression('NOW()')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Estatus'),
            'type' => Yii::t('app', 'Tipo de servicio'),
            'payed_status' => Yii::t('app', 'Estatus de pago'),
            'client_id' => Yii::t('app', 'Cliente'),
            'user_id' => Yii::t('app', 'Administrador'),
            'created_at' => Yii::t('app', 'Creado'),
            'previous_travel_id' => Yii::t('app', 'Servicio anterior'),
            'service_id' => Yii::t('app', 'Amenidades'),
            'from_zone_id' => Yii::t('app', 'From Zone'),
            'from_location' => Yii::t('app', 'From Location'),
            'from_address' => Yii::t('app', 'Origen'),
            'to_zone_id' => Yii::t('app', 'To Zone'),
            'to_location' => Yii::t('app', 'To Location'),
            'to_address' => Yii::t('app', 'Destino'),
            'passanger_name' => Yii::t('app', 'Información de los pasajeros'),
            'pickup' => Yii::t('app', 'Hora del servicio'),
            'dropoff' => Yii::t('app', 'Finaliza el servicio'),
            'total' => Yii::t('app', 'Total'),
            'payed' => Yii::t('app', 'Pagado'),
            'balance' => Yii::t('app', 'Saldo'),
            'reference' => Yii::t('app', 'Referencia'),
            'airline' => Yii::t('app', 'Aereolina'),
        ];
    }

    public static function quoteAdditional($qty, $additional_id)
    {
        $model = Additional::findOne($additional_id);
        if($model != null) {
            return $model->price * $qty;
        }

        return 0;
    }

    public static function publicQuoteVehicle($from_zone_id, $to_zone_id, $vehicle_type_id)
    {
        $rate = Rate::find()->where(['public' => Rate::PUBLIC_YES])->one();
        if($rate != null) {
            return VehicleTypeZoneRate::getRatePrice($from_zone_id, $to_zone_id, $rate->id, $vehicle_type_id);
        }
        
        return false;
    }

    public static function quoteVehicle($client_id, $type, $data)
    {
        $client = Client::findOne($client_id);
        if($client != null) {

            if($type == self::TYPE_SPECIAL) {
                $rate = VehicleTypeRate::getRatePrice($data['vehicle_type_id'], $client->rate_id);
                $date = Moment::createFromFormat('d/m/Y', $data['date']);
                if($date) {
                    $pickup = new Moment( sprintf('%s %s:00', $date->format('Y-m-d'), $data['pickup']) );
                    $dropoff = new Moment( sprintf('%s %s:00', $date->format('Y-m-d'), $data['dropoff']) );

                    $vo = $dropoff->from($pickup);
                    return $rate * ceil(abs($vo->getMinutes()) / 60);
                }
            } else {
                // var_dump($data); die();
                return VehicleTypeZoneRate::getRatePrice($data['from_zone_id'], $data['to_zone_id'], $client->rate_id, $data['vehicle_type_id']);
            }
        }

        return 0;
    }

    public function updateVehicle($id, $data)
    {
        $model = TravelVehicle::findOne($id);
        if($model != null) {

            $model->vehicle_type_id = $data['vehicle_type_id'];
            $model->adults = $data['adults'];
            $model->children = $data['children'];
            $model->bags = $data['bags'];

            if($this->client != null) {
                $model->vehicle_rate = VehicleTypeRate::getRatePrice($data['vehicle_type_id'], $this->client->rate_id);
            }

            if($this->client != null) {
                $model->vehicle_zone_rate = VehicleTypeZoneRate::getRatePrice($this->from_zone_id, $this->to_zone_id, $this->client->rate_id, $data['vehicle_type_id']);
            }
                 
            return $model->save() && $this->updateTotals();            
        }

        return false;
    }

    public function addVehicle($data)
    {
        $model = new TravelVehicle();
        $model->travel_id = $this->id;
        $model->vehicle_type_id = $data['vehicle_type_id'];
        if(isset($data['adults'])) {
            $model->adults = $data['adults'];
        }
        if(isset($data['children'])) {
            $model->children = $data['children'];
        }
        if(isset($data['bags'])) {
            $model->bags = $data['bags'];
        }


        if($this->client != null) {
            $model->vehicle_rate = VehicleTypeRate::getRatePrice($data['vehicle_type_id'], $this->client->rate_id);
        }

        if($this->client != null) {
            $model->vehicle_zone_rate = VehicleTypeZoneRate::getRatePrice($this->from_zone_id, $this->to_zone_id, $this->client->rate_id, $data['vehicle_type_id']);
        }
             
        return $model->save() && $this->updateTotals();
    }

    public function updateAdditional($id, $data)
    {
        $model = TravelAdditional::findOne($id);
        if($model != null) {

            $model->additional_id = $data['additional_id'];
            $model->qty = $data['qty'];
    
            $additional = Additional::findOne($data['additional_id']);
            if($additional != null) {
                $model->additional_id = $additional->id;
                $model->qty = $data['qty'];
                $model->price = $additional->price;
                $model->total = $model->qty * $additional->price;

                return $model->save() && $this->updateTotals();
                
            } else {
                return $model->delete() && $this->updateTotals();
            }
        }

        return false;
    }

    public function addAdditional($data)
    {
        $model = new TravelAdditional();
        $model->travel_id = $this->id;
        $model->additional_id = $data['additional_id'];

        $additional = Additional::findOne($data['additional_id']);

        if($additional != null) {
            $model->additional_id = $additional->id;
            $model->qty = $data['qty'];
            $model->price = $additional->price;
            $model->total = $model->qty * $additional->price;

            return $model->save() && $this->updateTotals();
        }
        return false;
    }

    public function addPayment($type, $amount, $details) {
        $model = new TravelPayment();
        $model->travel_id = $this->id;
        $model->status = TravelPayment::STATUS_VALIDATED;
        $model->created_at = date('Y-m-d H:i:s');
        $model->type = $type;
        $model->amount = $amount;
        $model->details = $details;

        if($model->save()) {
            $this->updateTotals();
            return $model;
        }

        return false;
    }

    public function updatePayed() {
        $this->payed = 0;
        foreach($this->payments as $payment) {
            if($payment->status == TravelPayment::STATUS_VALIDATED) {
                $this->payed += $payment->amount;
            }
        }

        return $this->update(['payed']);
    }

    public function updateTotals()
    {
        $this->total = 0;
        foreach($this->vehicles as $vehicle) {

            if($this->type != self::TYPE_SPECIAL) {
                $this->total += $vehicle->vehicle_zone_rate;
            } else {

                $pickup = new Moment( $this->pickup );
                $dropoff = new Moment( $this->dropoff );

                if($pickup != null && $dropoff != null) {
                    $vo = $dropoff->from($pickup);
                    $this->total += $vehicle->vehicle_rate * ceil(abs($vo->getMinutes()) / 60);                    
                } else {
                    $this->total += 0;    
                }
            }
        }

        foreach($this->additionals as $additional) {
            $this->total += $additional->total;
        }

        if($this->service != null) {
            $this->total += $this->service->price;
        }

        $this->total = 2;

        $this->updatePayed();
        $this->balance = $this->total - $this->payed;
        $this->update(['total', 'balance']);
        $this->refresh();

        if($this->payed == 0 && $this->total > 0) {
            $this->payed_status = self::PAYED_STATUS_PENDING;
        } else if($this->balance <= 0) {
            $this->payed_status = self::PAYED_STATUS_COMPLETE;
        } else if($this->balance > 0) {
            $this->payed_status = self::PAYED_STATUS_PARTIAL;
        }

        return $this->update(['payed_status']);
    }

    public function getFormatted($attr, $lang = 'es')
    {
        switch($attr)
        {
            case 'status':
                if(isset($this->status_options[$this->status])) {
                    return $this->status_options[$this->status];
                }
                break;
            case 'payed_status':
                if(isset($this->payed_status_options[$this->payed_status])) {
                    return $this->payed_status_options[$this->payed_status];
                }
                break;
            case 'type':
                if(isset($this->type_options[$this->type])) {
                    return $this->type_options[$this->type];
                }
                break;
            case 'card':

                $travel_label = Yii::t('app', 'Origen - Destino');
                $name_label = Yii::t('app', 'Titular');
                $ad_label = Yii::t('app', 'Fecha de llegada');
                $dd_label = Yii::t('app', 'Hora de llegada');
                $pass_label = Yii::t('app', 'Pasajeros');
                $veh_label = Yii::t('app', 'Vehículo');

                $card = [];
                $card[] = "<div class=\"col-xs-12\"><h5>{$travel_label}</h5><p>{$this->from_address} / {$this->to_address}</p></div>";
                $card[] = "<div class=\"col-xs-12\"><h5>{$name_label}</h5><p>" . $this->getFormatted('client.name') . "</p></div>";
                $card[] = "<div class=\"col-xs-6\"><h5>{$ad_label}</h5><p>" . date('d/m/Y', strtotime($this->pickup)) . "hrs.</p></div>";
                // $card[] = "<p>Aerol&iacute;nea y No. de Vuelo:</p>";
                $card[] = "<div class=\"col-xs-6\"><h5>{$dd_label}</h5><p>" . date('H:i', strtotime($this->pickup)) . "hrs.</p></div>";
                $card[] = "<div class=\"col-xs-12\"><h5>{$pass_label}</h5><p>{$this->passanger_name}</p></div>";

                $i = 1;
                foreach($this->vehicles as $vehicle) {
                    $card[] = "<div class=\"col-xs-6\"><h5>{$veh_label} {$i}</h5><p>{$vehicle->vehicleType->name}</p></div>";
                    $i++;
                }

                return implode("\n", $card);
                break;
            case 'client.name':
                return $this->client->profile->name;
                break;
        }

        return parent::getFormatted($attr, $lang);
    }

    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParent()
    {
        return $this->hasOne(Travel::className(), ['id' => 'previous_travel_id']);
    }

    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    public function getFromZone()
    {
        return $this->hasOne(Zone::className(), ['id' => 'from_zone_id']);
    }

    public function getToZone()
    {
        return $this->hasOne(Zone::className(), ['id' => 'to_zone_id']);
    }

    public function getAdditionals()
    {
        return $this->hasMany(TravelAdditional::className(), ['travel_id' => 'id']);
    }

    public function getPassangers()
    {
        return $this->hasMany(TravelPassenger::className(), ['travel_id' => 'id']);
    }

    public function getInfo()
    {
        return $this->hasMany(TravelInfo::className(), ['travel_id' => 'id']);
    }

    public function getPayments()
    {
        return $this->hasMany(TravelPayment::className(), ['travel_id' => 'id']);
    }

    public function getVehicles()
    {
        return $this->hasMany(TravelVehicle::className(), ['travel_id' => 'id']);
    }

}
