<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_translate".
 *
 * @property int $id
 * @property int $object_id
 * @property string $language
 * @property string $code
 * @property string $content
 */
class Translate extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_id', 'language', 'code'], 'required'],
            [['object_id'], 'integer'],
            [['language'], 'string', 'max' => 2],
            [['code'], 'string', 'max' => 60],
            [['content'], 'string', 'max' => 120],
            [['content'], 'default', 'value' => ''],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'object_id' => Yii::t('app', 'Object ID'),
            'language' => Yii::t('app', 'Language'),
            'code' => Yii::t('app', 'Code'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    public static function getContent($object_id, $code, $language)
    {
        $translate = Translate::find()->where([
            'object_id' => $object_id,
            'language' => $language,
            'code' => $code,
        ])->one();

        if( $translate != null ) {
            return $translate->content;
        }

        return '';
    }
}
