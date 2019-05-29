<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_vehicle_rate".
 *
 * @property int $id
 * @property int $vehicle_type_id
 * @property int $two_way
 * @property int $zone_id
 * @property int $zone2_id
 * @property double $price
 */
class VehicleRate extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_vehicle_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_type_id', 'two_way', 'zone_id', 'zone2_id', 'price'], 'required'],
            [['vehicle_type_id', 'two_way', 'zone_id', 'zone2_id'], 'integer'],
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
            'two_way' => Yii::t('app', 'Two Way'),
            'zone_id' => Yii::t('app', 'Zone ID'),
            'zone2_id' => Yii::t('app', 'Zone2 ID'),
            'price' => Yii::t('app', 'Price'),
        ];
    }
}
