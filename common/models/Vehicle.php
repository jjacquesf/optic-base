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
        self::STATUS_AVAILABLE => 'Disponible',
        self::STATUS_USELESS => 'No Disponible',
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
            'status' => Yii::t('app', 'Estatus'),
            'vehicle_type_id' => Yii::t('app', 'Tipo de vehículo'),
            'plate' => Yii::t('app', 'Placas'),
            'model' => Yii::t('app', 'Modelo (Año)'),
            'color' => Yii::t('app', 'Color'),
            'default_operator_id' => Yii::t('app', 'Operador por dedault'),
        ];
    }

    public function getVehicleType()
    {
        return $this->hasOne(VehicleType::className(), ['id' => 'vehicle_type_id']);
    }

    public function getDefaultOperator()
    {
        return $this->hasOne(User::className(), ['id' => 'default_operator_id']);
    }

    public function getFormatted($attr, $lang = 'es')
    {
        switch ($attr) {
            case 'status':
                return $this->status_options[$this->status] ? $this->status_options[$this->status] : '';
                break;
            case 'vehicle_type':
                return $this->vehicleType != null ? $this->vehicleType->name : 'Ninguno';
                break;
            case 'default_operator':
                return $this->defaultOperator != null ? $this->default_operator->profile->name : 'Ninguno';
                break;
            
            default:
                return parent::getFormatted($attr, $lang);
                break;
        }
    }
}
