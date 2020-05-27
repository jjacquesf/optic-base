<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_vehicle_type_zone_rate".
 *
 * @property int $id
 * @property int $rate_id
 * @property int $vehicle_type_id
 * @property int $two_way
 * @property int $zone_id
 * @property int $zone2_id
 * @property double $price
 */
class VehicleTypeZoneRate extends EActiveRecord
{
    const TWO_WAY_NO = 0;
    const TWO_WAY_YES = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_vehicle_type_zone_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate_id', 'vehicle_type_id', 'zone_id', 'zone2_id', 'price'], 'required'],
            [['rate_id', 'vehicle_type_id', 'two_way', 'zone_id', 'zone2_id'], 'integer'],
            [['price'], 'number'],
            ['two_way', 'default', 'value' => self::TWO_WAY_NO],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'rate_id' => Yii::t('app', 'Rate'),
            'vehicle_type_id' => Yii::t('app', 'Vehicle Type ID'),
            'two_way' => Yii::t('app', 'Two Way'),
            'zone_id' => Yii::t('app', 'Zone ID'),
            'zone2_id' => Yii::t('app', 'Zone2 ID'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    public static function setRatePrice($zone_id, $zone2_id, $rate_id, $vehicle_type_id, $price)
    {
        $model =  self::getRateModel($zone_id, $zone2_id, $rate_id, $vehicle_type_id);

        if($model != null) {
            $model->price = $price;
        } else {
            $model = new VehicleTypeZoneRate();
            
            $model->zone_id = $zone_id;
            $model->zone2_id = $zone2_id;
            $model->rate_id = $rate_id;
            $model->vehicle_type_id = $vehicle_type_id;
            $model->price = $price;
        }

        return $model->save();
    }

    public static function getRatePrice($zone_id, $zone2_id, $rate_id, $vehicle_type_id)
    {
        // var_dump($zone_id);
        // var_dump($zone2_id);
        // var_dump($rate_id);
        // var_dump($vehicle_type_id);
        // die();
        $model =  self::getRateModel($zone_id, $zone2_id, $rate_id, $vehicle_type_id);

        if($model != null) {
            return $model->price;
        }

        return 0;
    }

    private static function getRateModel($zone_id, $zone2_id, $rate_id, $vehicle_type_id)
    {
        return self::find()->where([
                    'zone_id' => $zone_id,
                    'zone2_id' => $zone2_id,
                    'rate_id' => $rate_id,
                    'vehicle_type_id' => $vehicle_type_id,
                ])->one();
    }
}
