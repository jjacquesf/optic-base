<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%vehicle_picture}}".
 *
 * @property int $id
 * @property int $vehicle_id
 * @property int $file_id
 */
class VehiclePicture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vehicle_picture}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_id', 'file_id'], 'required'],
            [['vehicle_id', 'file_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vehicle_id' => Yii::t('app', 'Vehicle ID'),
            'file_id' => Yii::t('app', 'File ID'),
        ];
    }

    public function getPictures()
    {
        return $this->hasOne(VehiclePicture::className(), ['id' => 'vehicle_id']);
    }
}
