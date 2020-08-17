<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "optic_additional".
 *
 * @property int $id
 * @property double $price
 * @property int $qty
 */
class Additional extends EActiveRecord
{
    public $translated_content = [
        'name' => 'Additional_name',
        'description' => 'Additional_description',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_additional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'qty'], 'required'],
            [['price'], 'number'],
            [['qty'], 'integer'],
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
            'qty' => Yii::t('app', 'Disponibles'),
            'name' => Yii::t('app', 'Nombre'),
            'description' => Yii::t('app', 'Descripción'),
        ];
    }


    public function getFormatted($attr, $lang = 'es')
    {
        switch ($attr) {
            case 'name':
                return $this->getTranslate('Additional_name', $lang);
                break;
            case 'description':
                return $this->getTranslate('Additional_description', $lang);
                break;
            
            default:
                return parent::getFormatted($attr, $lang);
                break;
        }
    }

    public function getTranslation()
    {
        return $this->hasOne(Translate::className(), ['object_id' => 'id'])
                    ->andWhere([
                        'optic_translate.code' => 'Additional_name',
                        'optic_translate.language' => Yii::$app->language,
                    ]);
    }

    public static function getList()
    {
        return self::find()
            ->joinWith(['translation'])
            ->orderBy(['optic_translate.content' => SORT_ASC])
            ->all();
    }

    public static function getListData()
    {
        return ArrayHelper::map(self::find()
                                        ->joinWith(['translation'])
                                        ->orderBy(['optic_translate.content' => SORT_ASC])
                                        ->all(), 'id', function($model) {
                                            return sprintf('%s ($ %s USD)', $model->translation->content, number_format($model->price, 2));
                                        });
    }
}
