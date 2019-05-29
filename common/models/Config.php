<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_config".
 *
 * @property int $id
 * @property int $status
 * @property int $public_vehicle_rate_id
 * @property int $public_vehicle_zone_rate_id
 */
class Config extends extends EActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    public $status_options = [
        self::STATUS_ENABLED => 'Activo',
        self::STATUS_DISABLED => 'Suspendido',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'public_vehicle_rate_id', 'public_vehicle_zone_rate_id'], 'required'],
            [['status', 'public_vehicle_rate_id', 'public_vehicle_zone_rate_id'], 'integer'],
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
            'public_vehicle_rate_id' => Yii::t('app', 'Public Vehicle Rate ID'),
            'public_vehicle_zone_rate_id' => Yii::t('app', 'Public Vehicle Zone Rate ID'),
        ];
    }

    public static function getValue($config)
    {
        $model = self::find();
        if(isset($model->{$config})) {
            return $model->{$config};
        }

        return false;
    }
}
