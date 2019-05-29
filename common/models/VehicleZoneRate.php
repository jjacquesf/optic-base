<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_vehicle_zone_rate".
 *
 * @property int $id
 * @property int $vehicle_type_id
 * @property double $price
 */
class VehicleZoneRate extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_vehicle_zone_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_type_id', 'price'], 'required'],
            [['vehicle_type_id'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vehicle_type_id' => Yii::t('app', 'Vehicle Type ID'),
            'price' => Yii::t('app', 'Price'),
        ];
    }
}
