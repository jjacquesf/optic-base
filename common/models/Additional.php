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
    public $translated_content = [
        'name' => 'Additional_name',
        'description' => 'Additional_description',
    ];

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
            'name' => Yii::t('app', 'Nombre'),
            'description' => Yii::t('app', 'Descripción'),
        ];
    }
}
