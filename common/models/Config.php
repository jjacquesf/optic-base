<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_config".
 *
 * @property int $id
 * @property int $status
 * @property int $rate_id
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
            [['status', 'rate_id'], 'required'],
            [['status', 'rate_id'], 'integer'],
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
            'rate_id' => Yii::t('app', 'tarifa pública'),
            'languages' => Yii::t('app', 'Idiomas'),
        ];
    }

    public static function getConfig()
    {
        return self::find()->one();
    }

    public static function getPublicRateId()
    {
        $model = self::getConfig();
        return $model->rate_id;
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
