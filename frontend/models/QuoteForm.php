<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\VehicleType;
use common\models\Travel;
use backend\models\TravelForm;
use common\models\ClientSignupForm;
use common\models\Client;
use common\models\Service;
use common\models\Config;

/**
 * QuoteForm is the model behind the contact form.
 */
class QuoteForm extends Model
{
    const SCENARIO_BOOK = 'BOOK';

    public $from_address;
    public $from_zone;
    public $from_location;
    public $from_zone_id;
    public $to_address;
    public $to_zone;
    public $to_location;
    public $to_zone_id;
    public $adults;
    public $children;
    public $infants;
    public $pickup_date;
    public $pickup_time;
    public $roundtrip;
    public $bags;

    public $additionals;
    public $comments;
    public $vehicle_type_id;
    public $client_id;
    public $client_name;
    public $client_phone;
    public $client_email;
    public $service_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_address', 'from_zone', 'from_location', 'from_zone_id',
                'to_address', 'to_zone', 'to_location', 'to_zone_id',
                'adults','children','infants','pickup_date', 'pickup_time'], 'required'],
            
                [['from_address', 'from_zone', 'from_location', 'from_zone_id',
                'to_address', 'to_zone', 'to_location', 'to_zone_id',
                'adults','children','infants','pickup_date', 'pickup_time', 'roundtrip', 'bags', 'additionals', 'comments'], 'safe'],

                [['comments'], 'string', 'max' => 255],
                [['client_name', 'client_phone', 'client_email'], 'string', 'max' => 120],
                [['adults','children','infants', 'bags', 'from_zone_id', 'to_zone_id', 'vehicle_type_id', 'client_id'], 'integer'],
                ['client_email', 'email'],
                [['vehicle_type_id', 'client_name', 'client_phone', 'client_email'], 'required', 'on' => self::SCENARIO_BOOK],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            
        ];
    }

    public function book() {
        // $model = new TravelForm();
        // $tvModel = new TravelVehicle();
        // $addModel = new TravelAdditional();

        $service = Service::find()->one();

        $model = new TravelForm();

        $client = Client::find()->where([
            'email' => $this->client_email,
            'status' => Client::STATUS_ACTIVE       
        ])->one();

        if($client == null) {
            
            if(!empty($this->client_id)) {
                $client = Client::find()->where([
                    'id' => $this->client_id,
                    'status' => Client::STATUS_ACTIVE       
                ])->one();
            }
    
            if($client == null) {
                $client = new ClientSignupForm();
                $client->status = Client::STATUS_ACTIVE;
                $client->name = $this->client_name;
                $client->contact_name = $this->client_name;
                $client->contact_phone = $this->client_phone;
                $client->email = $this->client_email;
                $client->rate_id = Config::getPublicRateId();
                $client->password = uniqid();
    
                $client = $client->signup();
            }
        }

        if($client) {
            $model->load($this->attributes, '');
            $model->date = $this->pickup_date; //date('d/m/Y', strtotime($this->pickup_date));
            $model->pickup = $this->pickup_time;
            $model->type = Travel::TYPE_ARRIVAL;
            $model->client_id = $client->id;
            $model->service_id = $service->id;
            $travel = $model->register();
            
            if($travel) {
                $travel->addVehicle([
                    'vehicle_type_id' => $this->vehicle_type_id,
                    'adults' => $this->adults,
                    'children' => $this->children * 1 + $this->infants * 1,
                    'bags' => $this->bags,
                ]);

                if(!empty($this->additionals) && is_array($this->additionals)) {
                    foreach($this->additionals as $additional_id => $qty) {
                        $travel->addAdditional([
                            'additional_id' => $additional_id,
                            'qty' => $qty,
                        ]);
                    }
                }

                return $travel;
            }
        }

        return false;
    }

    public function quote() {
        $passangers = $this->adults + $this->children + $this->infants;
        $vt_options = VehicleType::getOptions($passangers, $this->bags);

        $quotes = [];
        foreach($vt_options as $vt_option) {
            $quotes[] = [
                'vehicle' => $vt_option->attributes,
                'price' => Travel::publicQuoteVehicle($this->from_zone_id, $this->to_zone_id, $vt_option->id),
            ];
        }

        return $quotes;
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
