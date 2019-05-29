<?php

namespace common\models;

use Yii;
use yii\helpers\JSON;

/**
 * This is the model class for table "optic_travel_passenger".
 *
 * @property int $id
 * @property int $travel_id
 * @property int $adults
 * @property int $children
 * @property string $children_ages
 */
class TravelPassenger extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_travel_passenger';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['travel_id', 'adults', 'children', 'children_ages'], 'required'],
            [['travel_id', 'adults', 'children'], 'integer'],
            [['children_ages'], 'string', 'max' => 120],
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
            'adults' => Yii::t('app', 'Adults'),
            'children' => Yii::t('app', 'Children'),
            'children_ages' => Yii::t('app', 'Children Ages'),
        ];
    }

    public function getFormatted($attr, $lang)
    {
        switch ($attr) {
            'children_ages':
                return JSON::decode($this->children_ages);
                break;
            default:
                return parent::getFormatted($attr, $lang);
                break;
        }
    }

    public function getTravel()
    {
        return $this->hasOne(Travel::clasName(), ['id' => 'travel_id']);
    }
}
