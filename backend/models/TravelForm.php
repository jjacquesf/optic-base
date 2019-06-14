<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Travel;
use common\models\Sequence;
use yii\web\JsExpression;
use \DateTime;

/**
 * TravelForm represents the model behind the search form of `\common\models\Client`.
 */
class TravelForm extends Travel
{
	public $date;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'from_zone_id', 'from_location', 'from_address', 'pickup'], 'required'],

            // [['to_zone_id', 'to_location', 'to_address'], 'required'],

     //        [['to_zone_id', 'to_location', 'to_address'], 'required', 
     //    		'when' => function($model) {
     //    			return $model->type != Travel::TYPE_SPECIAL;
     //    		},
     //    		'whenClient' => new JsExpression('function (attribute, value) {
					// return parseInt( $("#travelform-type").val() ) != '.Travel::TYPE_SPECIAL.';
			  //    }'),
     //    	],

            [['type', 'client_id', 'previous_travel_id', 'service_id', 'from_zone_id', 'to_zone_id'], 'integer'],
            [['date', 'pickup', 'dropoff'], 'safe'],
            // [['total'], 'number'],
            [['from_location', 'from_address', 'to_location', 'to_address', 'passanger_name'], 'string', 'max' => 255],
        ];
    }
      
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        $labels['date'] = Yii::t('app', 'Fecha del servicio');

        return $labels;
    }

    public function updateData($model)
    {
        $date = DateTime::createFromFormat('d/m/Y', $this->date);

        if($date) {

            $model->service_id = $this->service_id;
            $model->from_zone_id = $this->from_zone_id;
            $model->from_location = $this->from_location;
            $model->from_address = $this->from_address;
            $model->type = $this->type;
            $model->client_id = $this->client_id;
            $model->previous_travel_id = $this->previous_travel_id;
            $model->to_zone_id   = $this->to_zone_id  ;
            $model->to_location = $this->to_location;
            $model->to_address = $this->to_address;
            $model->passanger_name = $this->passanger_name;
            $model->pickup = sprintf('%s %s:00', $date->format('Y-m-d'), $this->pickup);
            if($model->type == Travel::TYPE_SPECIAL) {
                $model->dropoff = sprintf('%s %s:00', $date->format('Y-m-d'), $this->dropoff);
            }

            return $model->save() ? $model : null;
        }

        return null;
    }

    /**
     * Save
     *
     * @param array $runValidation
     * @param array $attributeNames
     *
     * @return ActiveDataProvider
     */
    public function register()
    {

        $date = DateTime::createFromFormat('d/m/Y', $this->date);
        if($date) {

            $model = new Travel();
            $model->scenario = Travel::SCENARIO_CREATE;            
            $model->load($this->attributes, '');
            $model->status = self::STATUS_PENDING;
            $model->payed_status = self::PAYED_STATUS_PENDING;
            $model->user_id = Yii::$app->user->id;
            $model->total = 0;
            $model->payed = 0;
            $model->balance = 0;
            $model->reference = Sequence::getNext($this->type);
            $model->pickup = sprintf('%s %s:00', $date->format('Y-m-d'), $model->pickup);
            $model->dropoff = '';
            if($model->type == Travel::TYPE_SPECIAL) {
                $model->dropoff = sprintf('%s %s:00', $date->format('Y-m-d'), $model->dropoff);
            }

            $model->passanger_name = 'Lorem de pasajeros';

            return $model->save() ? $model : null;
        }

    	return null;
    }

}
