<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
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
 * @property double $balance
 */
class Client extends EActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_DISABLED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public $status_options = [
        self::STATUS_DISABLED => 'Suspendido',
        self::STATUS_INACTIVE => 'Por validar',
        self::STATUS_ACTIVE => 'Activo',
    ];

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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            [['user_id', 'status', 'created_at', 'updated_at', 'rate_id'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'email', 'rate_id'], 'required'],
            [['balance'], 'number'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['default_location', 'default_address'], 'string', 'max' => 120],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],

            [['default_location', 'default_address'], 'default', 'value' => ''],
            ['default_zone', 'default', 'value' => 0],

            ['balance', 'default', 'value' => 0],
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
            'rate_id' => Yii::t('app', 'Tarifa'),
            'balance' => Yii::t('app', 'Saldo'),
        ];
    }

    public static function getListData()
    {
        return ArrayHelper::map(self::find()->where(['status' => self::STATUS_ACTIVE])->all(), 'id', 'profile.name');
    }

    public function getFormatted($attr, $lang = 'es')
    {
        switch($attr)
        {
            case 'status':

                if(isset($this->status_options[$this->status])) {
                    return $this->status_options[$this->status];
                }

                return $this->status;

                break;
            default:
                return parent::getFormatted($attr, $lang);
                break;
        }
    }

    public function getProfile()
    {
        return $this->hasOne(ClientProfile::className(), ['client_id' => 'id']);
    }

    public function getRate()
    {
        return $this->hasOne(Rate::className(), ['id' => 'rate_id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
