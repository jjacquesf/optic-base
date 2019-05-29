<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_service".
 *
 * @property int $id
 * @property double $price
 */
class Service extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'required'],
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
            'price' => Yii::t('app', 'Price'),
        ];
    }

    public function getTravels()
    {
        return $this->hasMany(Travel::className(), ['service_id' => 'id']);
    }
}
