<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Travel;
use yii\db\Expression;

/**
 * TravelSearch represents the model behind the search form of `common\models\Travel`.
 */
class TravelSearch extends Travel
{
    public $from_date;
    public $to_date;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reference', 'status', 'type', 'payed_status', 'client_id', 'user_id', 'previous_travel_id', 'service_id', 'from_zone_id', 'to_zone_id'], 'integer'],
            [['created_at', 'from_location', 'from_address', 'to_location', 'to_address', 'passanger_name', 'pickup', 'dropoff', 'from_date', 'to_date'], 'safe'],
            [['total', 'payed', 'balance'], 'number'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($type, $params)
    {

        $query = Travel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'type' => $type,
            'payed_status' => $this->payed_status,
            'client_id' => $this->client_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'previous_travel_id' => $this->previous_travel_id,
            'service_id' => $this->service_id,
            'from_zone_id' => $this->from_zone_id,
            'to_zone_id' => $this->to_zone_id,
            'pickup' => $this->pickup,
            'dropoff' => $this->dropoff,
            'total' => $this->total,
            'payed' => $this->payed,
            'balance' => $this->balance,
        ]);

        $query
            ->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'from_location', $this->from_location])
            ->andFilterWhere(['like', 'from_address', $this->from_address])
            ->andFilterWhere(['like', 'to_location', $this->to_location])
            ->andFilterWhere(['like', 'to_address', $this->to_address])
            ->andFilterWhere(['like', 'passanger_name', $this->passanger_name]);


        if( empty($this->from_date) ) {
            $this->from_date = date('Y-m-d');
        }

        if( empty($this->to_date) ) {
            $this->to_date = date('Y-m-d');
        }
        
        $query->andWhere('( DATE(pickup) >= :from_date AND DATE(pickup) <= :to_date )')
                ->addParams([':from_date' => $this->from_date, ':to_date' => $this->to_date]);    


        return $dataProvider;
    }
}
