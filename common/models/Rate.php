<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\ClientSignupForm;

/**
 * This is the model class for table "{{%rate}}".
 *
 * @property int $id
 * @property string $name
 */
class Rate extends \yii\db\ActiveRecord
{
    const PUBLIC_YES = 1;
    const PUBLIC_NO = 0;

    public $public_options = [
        self::PUBLIC_NO => 'No',
        self::PUBLIC_YES => 'Si',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'public'], 'required'],
            ['public', 'integer'],
            [['name'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Nombre tarifa'),
        ];
    }

    public function upateRates($data)
    {
        if(!$this->isNewRecord) {
            if(isset($data['VehicleTypeRate'])) {
                foreach($data['VehicleTypeRate'] as $vt_id => $price) {
                    VehicleTypeRate::setRatePrice($vt_id, $this->id, $price);
                }
            }   

            if(isset($data['VehicleTypeZoneRate'])) {
                foreach($data['VehicleTypeZoneRate'] as $zones_id => $vt_ids) {

                    @list($z1_id, $z2_id) = explode('_', $zones_id);
                    foreach($vt_ids as $vt_id => $price) {
                        VehicleTypeZoneRate::setRatePrice($z1_id, $z2_id, $this->id, $vt_id, $price);
                    }
                }
            }   
            
            return true;         
        }

        return false;
    }

    public static function getListData()
    {
        return ArrayHelper::map(self::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public function getVehicleTypeRate($vehicle_type_id)
    {
        return VehicleTypeRate::getRatePrice($vehicle_type_id, $this->id);
    }

    public function getVehicleTypeZoneRate($zone_id, $zone2_id, $vehicle_type_id)
    {   
        return VehicleTypeZoneRate::getRatePrice($zone_id, $zone2_id, $this->id, $vehicle_type_id);
    }

    public function getClients()
    {
        return $this->hasMany(Client::className(), ['rate_id' => 'id']);
    }

    public function getVehicleTypeRates()
    {
        return $this->hasOne(VehicleTypeRate::className(), ['rate_id' => 'id']);
    }

    public function getVehicleTypeZoneRates()
    {
        return $this->hasMany(VehicleTypeZoneRate::className(), ['rate_id' => 'id']);
    }
}
