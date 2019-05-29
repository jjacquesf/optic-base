<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "optic_client".
 *
 * @property int $id
 * @property int $user_id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $verification_token
 * @property int $default_zone
 * @property string $default_location
 * @property string $default_address
 * @property int $vehicle_rate_id
 * @property int $vehicle_zone_rate_id
 * @property double $balance
 */
class Client extends EActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'created_at', 'updated_at', 'default_zone', 'vehicle_rate_id', 'vehicle_zone_rate_id'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'default_zone', 'default_location', 'default_address', 'vehicle_rate_id', 'vehicle_zone_rate_id', 'balance'], 'required'],
            [['balance'], 'number'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['default_location', 'default_address'], 'string', 'max' => 120],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
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
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verification_token' => Yii::t('app', 'Verification Token'),
            'default_zone' => Yii::t('app', 'Default Zone'),
            'default_location' => Yii::t('app', 'Default Location'),
            'default_address' => Yii::t('app', 'Default Address'),
            'vehicle_rate_id' => Yii::t('app', 'Vehicle Rate ID'),
            'vehicle_zone_rate_id' => Yii::t('app', 'Vehicle Zone Rate ID'),
            'balance' => Yii::t('app', 'Balance'),
        ];
    }
}
