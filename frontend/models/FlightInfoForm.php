<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * FlightInfoForm is the model behind the contact form.
 */
class FlightInfoForm extends Model
{
    public $flight;
    public $airline;
    public $passangers;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['flight', 'airline', 'passangers'], 'required'],
            [['flight','airline'], 'string', 'max' => 25],
            [['passanger_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'flight' => Yii::t('app', 'Vuelo'),
            'airline' => Yii::t('app', 'Aereolinea'),
            'passangers' => Yii::t('app', 'Pasajeros'),
        ];
    }

}
