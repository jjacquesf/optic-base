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
 * @property string $details
 */
class TravelPayment extends EActiveRecord
{
    const TYPE_PAYPAL = 1;
    const TYPE_CC = 2;

    const STATUS_PENDING = 0;
    const STATUS_VALIDATED = 1;

    public $type_options = [
        self::TYPE_PAYPAL => 'Paypal',
        self::TYPE_CC => 'Tarjeta de crédito',
    ];


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
            [['status', 'created_at', 'travel_id', 'type', 'amount'], 'required'],
            [['status', 'file_id', 'travel_id', 'type'], 'integer'],
            [['details'], 'string', 'max' => 255],
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
            'details' => Yii::t('app', 'Details'),
        ];
    }

    public function getFormatted($attr, $lang = 'es') {
        switch($attr)
        {
            case 'type':
                if(isset($this->type_options[$this->type])) {
                    return $this->type_options[$this->type];
                }
                break;
            case 'amount':
                return '$ ' . number_format($this->amount, 2, '.', ',') . ' USD';
                break;
            case 'details':
                return nl2br($this->details);
                break;
        }

        return parent::getFormatted($attr, $lang);
    }

    public function getTravel()
    {
        return $this->hasOne(Travel::clasName(), ['id' => 'travel_id']);
    }
}
