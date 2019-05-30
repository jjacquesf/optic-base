<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%client_profile}}".
 *
 * @property int $id
 * @property int $client_id
 * @property int $file_id
 * @property string $name
 * @property string $contact_name
 * @property string $contact_phone
 */
class ClientProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client_profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'name', 'contact_name', 'contact_phone'], 'required'],
            [['client_id', 'file_id'], 'integer'],
            [['name', 'contact_name'], 'string', 'max' => 60],
            [['contact_phone'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_id' => Yii::t('app', 'Client ID'),
            'file_id' => Yii::t('app', 'File ID'),
            'name' => Yii::t('app', 'Nombre'),
            'contact_name' => Yii::t('app', 'Contact Name'),
            'contact_phone' => Yii::t('app', 'Contact Phone'),
        ];
    }
}
