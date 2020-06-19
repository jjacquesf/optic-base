<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Travel;

/**
 * SearchTravelForm model.
 */
class SearchTravelForm extends Model
{
    public $reference;
    public $email;
    public $date;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // email
            [['email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            [['reference', 'date'], 'string'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reference' => Yii::t('app', 'Referencia'),
            'email' => Yii::t('app', 'Mi Email'),
            'date' => Yii::t('app', 'Fecha'),
        ];
    }

    public function search() {
        
        $query = Travel::find()
                        ->joinWith(['client'])
                        ->where(['optic_client.email' => $this->email, 'optic_travel.reference' => $this->reference]);

        if(!empty($this->date)) {
            $date = \DateTime::createFromFormat('d/m/Y', $this->date);
            if($date) {
                $query->andWhere("DATE(pickup) = :date");
                $query->addParams([
                    ':date' => $date->format('Y-m-d')
                ]);
            }
        }

        return $query->one();
    }

}
