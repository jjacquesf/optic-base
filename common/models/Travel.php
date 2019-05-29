<?php

namespace common\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "optic_travel".
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
    const STATUS_ACTIVE = 1;
    const STATUS_COMPLETE = 1;

    const TYPE_ARRIVAL = 1;
    const TYPE_DEPARTURE = 2;
    const TYPE_SPECIAL = 3;
    const TYPE_COLLECTIVE_ARRIVAL = 4;
    const TYPE_COLLECTIVE_DEPARTURE = 5;

    const PAYED_STATUS_PENDING = 0;
    const PAYED_STATUS_PARTIAL = 1;
    const PAYED_STATUS_COMPLETE = 2;

    public $status_options = [
        self::STATUS_CANCELED => Yii::t('app', 'Cancelado'),
        self::STATUS_PENDING => Yii::t('app', 'Pendiente'),
        self::STATUS_ACTIVE => Yii::t('app', 'En Servicio'),
        self::STATUS_COMPLETE => Yii::t('app', 'Completa'),
    ];

    public $type_options = [
        self::TYPE_ARRIVAL => Yii::t('app', 'Llegada'),
        self::TYPE_DEPARTURE => Yii::t('app', 'Salida'),
        self::TYPE_SPECIAL => Yii::t('app', 'Especial'),
        self::TYPE_COLLECTIVE_ARRIVAL => Yii::t('app', 'Llegada Colectiva'),
        self::TYPE_COLLECTIVE_DEPARTURE => Yii::t('app', 'Salida Colectiva'),
    ];

    public $type_options = [
        self::PAYED_STATUS_PENDING => Yii::t('app', 'Pendiente'),
        self::PAYED_STATUS_PARTIAL => Yii::t('app', 'Parcial'),
        self::PAYED_STATUS_COMPLETE => Yii::t('app', 'Completo'),
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
        return 'optic_travel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'type', 'payed_status', 'client_id', 'created_at', 'service_id', 'from_zone_id', 'from_location', 'from_address', 'to_zone_id', 'to_location', 'to_address', 'passanger_name', 'pickup', 'total', 'payed', 'balance'], 'required'],
            [['status', 'type', 'payed_status', 'client_id', 'user_id', 'previous_travel_id', 'service_id', 'from_zone_id', 'to_zone_id'], 'integer'],
            [['created_at', 'pickup'], 'safe'],
            [['total', 'payed', 'balance'], 'number'],
            [['from_location', 'from_address', 'to_location', 'to_address', 'passanger_name'], 'string', 'max' => 120],

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
            'status' => Yii::t('app', 'Status'),
            'type' => Yii::t('app', 'Type'),
            'payed_status' => Yii::t('app', 'Payed Status'),
            'client_id' => Yii::t('app', 'Client ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'previous_travel_id' => Yii::t('app', 'Previous Travel ID'),
            'service_id' => Yii::t('app', 'Service ID'),
            'from_zone_id' => Yii::t('app', 'From Zone'),
            'from_location' => Yii::t('app', 'From Location'),
            'from_address' => Yii::t('app', 'From Address'),
            'to_zone_id' => Yii::t('app', 'To Zone'),
            'to_location' => Yii::t('app', 'To Location'),
            'to_address' => Yii::t('app', 'To Address'),
            'passanger_name' => Yii::t('app', 'Passanger Name'),
            'pickup' => Yii::t('app', 'Pickup'),
            'total' => Yii::t('app', 'Total'),
            'payed' => Yii::t('app', 'Payed'),
            'balance' => Yii::t('app', 'Balance'),
        ];
    }

    public function getFormatted($attr, $lang)
    {
        return parent::getFormatted($attr, $lang)
    }

    public function getClient()
    {
        return $this->hasOne(Client::clasName(), ['id' => 'client_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::clasName(), ['id' => 'user_id']);
    }

    public function getParent()
    {
        return $this->hasOne(Travel::clasName(), ['id' => 'previous_travel_id']);
    }

    public function getService()
    {
        return $this->hasOne(Service::clasName(), ['id' => 'service_id']);
    }

    public function getFromZone()
    {
        return $this->hasOne(Zone::clasName(), ['id' => 'from_zone_id']);
    }

    public function getToZone()
    {
        return $this->hasOne(Zone::clasName(), ['id' => 'to_zone_id']);
    }

    public function getAdditionals()
    {
        return $this->hasMany(TravelAdditional::clasName(), ['id' => 'travel_id']);
    }

    public function getAdditionals()
    {
        return $this->hasMany(TravelAdditional::clasName(), ['travel_id' => 'id']);
    }

    public function getPassangers()
    {
        return $this->hasMany(TravelPassangers::clasName(), ['travel_id' => 'id']);
    }

    public function getInfo()
    {
        return $this->hasMany(TravelInfo::clasName(), ['travel_id' => 'id']);
    }

    public function getPayments()
    {
        return $this->hasMany(TravelInfo::clasName(), ['travel_id' => 'id']);
    }

    public function getVehicles()
    {
        return $this->hasMany(TravelInfo::clasName(), ['travel_id' => 'id']);
    }


}
