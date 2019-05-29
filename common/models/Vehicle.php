<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_vehicle".
 *
 * @property int $id
 * @property int $status
 * @property int $vehicle_type_id
 * @property string $plate
 * @property int $model
 * @property string $color
 * @property int $default_operator_id
 */
class Vehicle extends EActiveRecord
{
    const STATUS_USELESS = 0;
    const STATUS_AVAILABLE = 1;

    public $status_options = [
        self::STATUS_USELESS => 'No Disponible',
        self::STATUS_AVAILABLE => 'Disponible',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'vehicle_type_id', 'plate', 'model', 'color'], 'required'],
            [['status', 'vehicle_type_id', 'model', 'default_operator_id'], 'integer'],
            [['plate'], 'string', 'max' => 10],
            [['color'], 'string', 'max' => 60],
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
            'vehicle_type_id' => Yii::t('app', 'Vehicle Type ID'),
            'plate' => Yii::t('app', 'Plate'),
            'model' => Yii::t('app', 'Model'),
            'color' => Yii::t('app', 'Color'),
            'default_operator_id' => Yii::t('app', 'Default Operator ID'),
        ];
    }

    public function getVehicleType()
    {
        return $this->hasOne(VehicleType::clasName(), ['id' => 'vehicle_type_id']);
    }

    public function getDefaultOperator()
    {
        return $this->hasOne(User::clasName(), ['id' => 'default_operator_id']);
    }
}
