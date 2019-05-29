<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_travel_additional".
 *
 * @property int $id
 * @property int $travel_id
 * @property int $additional_id
 * @property int $qty
 * @property double $price
 * @property double $total
 */
class TravelAdditional extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_travel_additional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['travel_id', 'additional_id', 'qty', 'price', 'total'], 'required'],
            [['travel_id', 'additional_id', 'qty'], 'integer'],
            [['price', 'total'], 'number'],
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
            'additional_id' => Yii::t('app', 'Additional ID'),
            'qty' => Yii::t('app', 'Qty'),
            'price' => Yii::t('app', 'Price'),
            'total' => Yii::t('app', 'Total'),
        ];
    }

    public function getTravel()
    {
        return $this->hasOne(Travel::clasName(), ['id' => 'travel_id']);
    }
}
