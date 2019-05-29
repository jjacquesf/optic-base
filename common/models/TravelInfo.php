<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_travel_info".
 *
 * @property int $id
 * @property int $travel_id
 * @property string $code
 * @property string $content
 */
class TravelInfo extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_travel_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['travel_id', 'code', 'content'], 'required'],
            [['travel_id'], 'integer'],
            [['code'], 'string', 'max' => 60],
            [['content'], 'string', 'max' => 255],
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
            'code' => Yii::t('app', 'Code'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    public function getTravel()
    {
        return $this->hasOne(Travel::clasName(), ['id' => 'travel_id']);
    }
}
