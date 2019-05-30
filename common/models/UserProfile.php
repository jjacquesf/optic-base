<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_user_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property int $file_id
 * @property string $name
 * @property string $phone
 * @property string $licence
 * @property int $freeday
 */
class UserProfile extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id', 'file_id', 'freeday'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['phone'], 'string', 'max' => 25],
            [['licence'], 'string', 'max' => 15],
            [['phone', 'licence', 'freeday'], 'default', 'value' => ''],
            ['file_id', 'default', 'value' => 0],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\upload\UploadBehavior',
                'attribute' => 'file',
                'savedAttribute' => 'file_id',
                'uploadPath' => '@common/upload',
                'autoSave' => true, 
                'autoDelete' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'file_id' => Yii::t('app', 'File ID'),
            'file' => Yii::t('app', 'File ID'),
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'licence' => Yii::t('app', 'Licence'),
            'freeday' => Yii::t('app', 'Freeday'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
