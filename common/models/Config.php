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
 * @property string $languages
 */
class Config extends EActiveRecord
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
            ['languages', 'default', 'value' => 'es|en']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Estado'),
            'public_vehicle_rate_id' => Yii::t('app', 'tarifa publica por hora'),
            'public_vehicle_zone_rate_id' => Yii::t('app', 'Tarifa publica por zona'),
            'languages' => Yii::t('app', 'Idiomas'),
        ];
    }

    public static function getConfig()
    {
        return self::find()->one();
    }

    public static function getLangs()
    {
        $model = self::getConfig();
        return explode('|', $model->languages);
    }

    public static function isLanguageAvailable($lang)
    {
        $languages = self::getLangs();

        return in_array($lang, $languages) ? true : false;
    }

    public static function getValue($config)
    {
        $model = self::getConfig();
        if(isset($model->{$config})) {
            return $model->{$config};
        }

        return false;
    }
}
