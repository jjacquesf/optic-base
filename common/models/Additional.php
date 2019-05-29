<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_additional".
 *
 * @property int $id
 * @property double $price
 * @property int $qty
 */
class Additional extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_additional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'qty'], 'required'],
            [['price'], 'number'],
            [['qty'], 'integer'],
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
            'qty' => Yii::t('app', 'Qty'),
        ];
    }
}
