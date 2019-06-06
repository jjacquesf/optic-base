<?php

namespace common\models;

use Yii;
use yii\db\Expression;

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

    public $status_options = [
        self::STATUS_CANCELED => 'Cancelado',
        self::STATUS_PENDING => 'Pendiente',
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
        self::PAYED_STATUS_PENDING => 'Pendiente',
        self::PAYED_STATUS_PARTIAL => 'Parcial',
        self::PAYED_STATUS_COMPLETE => 'Completo',
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
            [['status', 'type', 'payed_status', 'client_id', 'service_id', 'from_zone_id', 'from_location', 'from_address', 'to_zone_id', 'to_location', 'to_address', 'passanger_name', 'pickup', 'total', 'payed', 'balance'], 'required'],
            [['status', 'type', 'payed_status', 'client_id', 'user_id', 'previous_travel_id', 'service_id', 'from_zone_id', 'to_zone_id'], 'integer'],
            [['created_at', 'pickup'], 'safe'],
            [['total', 'payed', 'balance'], 'number'],
            [['from_location', 'from_address', 'to_location', 'to_address', 'passanger_name'], 'string', 'max' => 255],
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
            'passanger_name' => Yii::t('app', 'Información de los pasajero'),
            'pickup' => Yii::t('app', 'Hora del servicio'),
            'dropoff' => Yii::t('app', 'Finaliza el servicio'),
            'total' => Yii::t('app', 'Total'),
            'payed' => Yii::t('app', 'Pagado'),
            'balance' => Yii::t('app', 'Saldo'),
            'reference' => Yii::t('app', 'Referencia'),
        ];
    }

    public function addVehicle($data)
    {
        $model = new TravelVehicle();
        $model->travel_id = $this->id;
        $model->vehicle_type_id = $data['vehicle_type_id'];


        if($this->client != null) {
            $model->vehicle_rate = VehicleTypeRate::getRatePrice($data['vehicle_type_id'], $this->client->rate_id);
        }

        if($this->client != null) {
            $model->vehicle_zone_rate = VehicleTypeZoneRate::getRatePrice($this->from_zone_id, $this->to_zone_id, $this->client->rate_id, $data['vehicle_type_id']);
        }

        
        $model->validate();
        // var_dump($model->getErrors());
        // die();

        return $model->save() && $this->updateTotals();
    }

    public function updateTotals()
    {
        $this->total = 0;
        foreach($this->vehicles as $vehicle) {
            $this->total += $vehicle->vehicle_zone_rate;
        }

        if($this->service != null) {
            $this->total += $this->service->price;
        }

        $this->balance = $this->total - $this->payed;

        return $this->save();
    }

    public function getFormatted($attr, $lang = 'es')
    {
        switch($attr)
        {
            case 'type':
                if(isset($this->type_options[$this->type])) {
                    return $this->type_options[$this->type];
                }
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
        return $this->hasMany(TravelPassangers::className(), ['travel_id' => 'id']);
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
