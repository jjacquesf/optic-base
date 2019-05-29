<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_vehicle_type".
 *
 * @property int $id
 * @property string $name
 * @property int $max_passangers
 * @property int $max_bags
 */
class VehicleType extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_vehicle_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'max_passangers', 'max_bags'], 'required'],
            [['max_passangers', 'max_bags'], 'integer'],
            [['name'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'max_passangers' => Yii::t('app', 'Max Passangers'),
            'max_bags' => Yii::t('app', 'Max Bags'),
        ];
    }
}
