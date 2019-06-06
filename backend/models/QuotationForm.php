<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Quotation form
 */
class QuotationForm extends Model
{
    public $from;
    public $to;
    public $from_point;
    public $to_point;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from', 'to', 'from_point', 'to_point'], 'required'],
            [['from', 'to', 'from_point', 'to_point'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'from' => Yii::t('app', 'Origen'),
            'to' => Yii::t('app', 'Destino'),
        ];
    }


    public function request()
    {
    	// cotizar
    }
}
