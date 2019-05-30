<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_zone".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $points
 */
class Zone extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_zone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'points'], 'required'],
            [['points'], 'string'],
            [['name', 'description'], 'string', 'max' => 60],
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
            'description' => Yii::t('app', 'Descripción'),
            'points' => Yii::t('app', 'Puntos'),
        ];
    }

    public function getTravelsFrom()
    {
        return $this->hasOne(Travel::clasName(), ['from_zone_id' => 'id']);
    }

    public function getTravelsTo()
    {
        return $this->hasOne(Travel::clasName(), ['to_zone_id' => 'id']);
    }
}
