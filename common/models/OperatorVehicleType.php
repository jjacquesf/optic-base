<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_operator_vehicle_type".
 *
 * @property int $id
 * @property int $user_id
 * @property int $vehicle_type_id
 */
class OperatorVehicleType extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_operator_vehicle_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'vehicle_type_id'], 'required'],
            [['user_id', 'vehicle_type_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'vehicle_type_id' => Yii::t('app', 'Vehicle Type ID'),
        ];
    }

    public function getVehicles()
    {
        return $this->hasMany(Vehicle::className(), ['vehicle_type_id' => 'id']);
    }
}
