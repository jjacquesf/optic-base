<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "optic_service".
 *
 * @property int $id
 * @property double $price
 */
class Service extends EActiveRecord
{
    public $translated_content = [
        'name' => 'Service_name',
        'description' => 'Service_description',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'required'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'price' => Yii::t('app', 'Precio'),
            'name' => Yii::t('app', 'Nombre'),
            'description' => Yii::t('app', 'Descripción'),
        ];
    }

    public function getFormatted($attr, $lang = 'es')
    {
        switch ($attr) {
            case 'name':
                return $this->getTranslate('Service_name', $lang);
                break;
            case 'description':
                return $this->getTranslate('Service_description', $lang);
                break;
            
            default:
                return parent::getFormatted($attr, $lang);
                break;
        }
    }

    public function getTravels()
    {
        return $this->hasMany(Travel::className(), ['service_id' => 'id']);
    }

    public function getTranslation()
    {
        return $this->hasOne(Translate::className(), ['object_id' => 'id'])
                    ->andWhere([
                        'optic_translate.code' => 'Service_name',
                        'optic_translate.language' => Yii::$app->language,
                    ]);
    }

    public static function getListData()
    {
        return ArrayHelper::map(self::find()
                                        ->joinWith(['translation'])
                                        ->orderBy(['optic_translate.content' => SORT_ASC])
                                        ->all(), 'id', 'translation.content');
    }
}
