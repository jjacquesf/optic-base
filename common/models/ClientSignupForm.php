<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Client;
use common\models\Config;

/**
 * ClientSignup form
 */
class ClientSignupForm extends Model
{
    public $name;
    public $contact_name;
    public $contact_phone;
    public $email;
    public $password;
    public $rate_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        	['name', 'trim'],
            ['name', 'required'],

            ['contact_name', 'trim'],
            ['contact_name', 'required'],

            ['contact_phone', 'trim'],
            ['contact_phone', 'required'],

            [['name', 'contact_name', 'contact_phone'], 'string', 'max' => 60],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Client', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['rate_id', 'default', 'value' => Config::getConfig('rate_id')],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $client = new Client();
        $client->rate_id = $this->rate_id;
        
        $client->email = $this->email;
        $client->username = $this->email;
        $client->email = $this->email;
        $client->setPassword($this->password);
        $client->generateAuthKey();
        $client->generateEmailVerificationToken();

        if($client->save()) {
        	$profile = new ClientProfile();
        	$profile->client_id = $client->id;
        	$profile->name = $this->name;
        	$profile->contact_name = $this->contact_name;
        	$profile->contact_phone = $this->contact_phone;

        	if(!$profile->save()) {
        		$client->delete();
        		return $client;
        	}

        	return $client;
        } else {
            var_dump($client->getErrors()); die();
        }

        return $client->save();

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Nombre'),
            'contact_name' => Yii::t('app', 'Contacto'),
            'contact_phone' => Yii::t('app', 'Teléfono'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Contraseña'),
            'rate_id' => Yii::t('app', 'Tarifa'),
        ];
    }

    /**
     * Sends confirmation email to user
     * @param Client $client user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return true;

        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
