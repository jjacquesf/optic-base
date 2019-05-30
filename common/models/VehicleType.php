<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;


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
            'name' => Yii::t('app', 'Nombre'),
            'max_passangers' => Yii::t('app', 'Pasajeros (max)'),
            'max_bags' => Yii::t('app', 'Maletas (max)'),
        ];
    }

    public static function getListData()
    {
        return ArrayHelper::map(self::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }
}
