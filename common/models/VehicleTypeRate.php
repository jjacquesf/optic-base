<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_vehicle_type_rate".
 *
 * @property int $id
 * @property int $vehicle_type_id
 * @property int $rate_id
 * @property double $price
 */
class VehicleTypeRate extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_vehicle_type_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate_id', 'vehicle_type_id', 'price'], 'required'],
            [['rate_id', 'vehicle_type_id'], 'integer'],
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
            'rate_id' => Yii::t('app', 'Rate'),
            'vehicle_type_id' => Yii::t('app', 'Vehicle Type ID'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    public function getRate()
    {
        return $this->hasOne(Rate::className(), ['id' => 'rate_id']);
    }

    public static function setRatePrice($vehicle_type_id, $rate_id, $price)
    {
        $model =  self::getRateModel($vehicle_type_id, $rate_id);

        if($model != null) {
            $model->price = $price;
        } else {
            $model = new VehicleTypeRate();
            $model->vehicle_type_id = $vehicle_type_id;
            $model->rate_id = $rate_id;
            $model->price = $price;
        }

        return $model->save();
    }

    public static function getRatePrice($vehicle_type_id, $rate_id)
    {
        $model =  self::getRateModel($vehicle_type_id, $rate_id);

        if($model != null) {
            return $model->price;
        }

        return 0;
    }  

    private static function getRateModel($vehicle_type_id, $rate_id)
    {
        return self::find()->where([
                    'vehicle_type_id' => $vehicle_type_id,
                    'rate_id' => $rate_id,
                ])->one();
    }
}
