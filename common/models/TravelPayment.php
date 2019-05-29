<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_travel_payment".
 *
 * @property int $id
 * @property int $status
 * @property int $file_id
 * @property string $created_at
 * @property int $travel_id
 * @property int $type
 * @property double $amount
 */
class TravelPayment extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_travel_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'file_id', 'created_at', 'travel_id', 'type', 'amount'], 'required'],
            [['status', 'file_id', 'travel_id', 'type'], 'integer'],
            [['created_at'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'file_id' => Yii::t('app', 'File ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'travel_id' => Yii::t('app', 'Travel ID'),
            'type' => Yii::t('app', 'Type'),
            'amount' => Yii::t('app', 'Amount'),
        ];
    }

    public function getTravel()
    {
        return $this->hasOne(Travel::clasName(), ['id' => 'travel_id']);
    }
}
