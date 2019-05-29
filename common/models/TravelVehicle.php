<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%travel_vehicle}}".
 *
 * @property int $id
 * @property int $travel_id
 * @property int $vehicle_type_id
 * @property int $vehicle_id
 * @property int $operator_id
 * @property double $vehicle_rate
 * @property double $vehicle_zone_rate
 */
class TravelVehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%travel_vehicle}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['travel_id', 'vehicle_type_id', 'vehicle_rate', 'vehicle_zone_rate'], 'required'],
            [['travel_id', 'vehicle_type_id', 'vehicle_id', 'operator_id'], 'integer'],
            [['vehicle_rate', 'vehicle_zone_rate'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'travel_id' => Yii::t('app', 'Travel ID'),
            'vehicle_type_id' => Yii::t('app', 'Vehicle Type ID'),
            'vehicle_id' => Yii::t('app', 'Vehicle ID'),
            'operator_id' => Yii::t('app', 'Operator ID'),
            'vehicle_rate' => Yii::t('app', 'Vehicle Rate'),
            'vehicle_zone_rate' => Yii::t('app', 'Vehicle Zone Rate'),
        ];
    }
    
    public function getTravel()
    {
        return $this->hasOne(Travel::clasName(), ['id' => 'travel_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(User::clasName(), ['id' => 'user_id']);
    }

    public function getVehicleType()
    {
        return $this->hasOne(VehicleType::clasName(), ['id' => 'vehicle_type_id']);
    }

    public function getVehicle()
    {
        return $this->hasOne(Vehicle::clasName(), ['id' => 'vehicle_id']);
    }
}
