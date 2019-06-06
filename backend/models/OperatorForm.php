<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserProfile;
use common\models\Config;

/**
 * Operator form
 */
class OperatorForm extends User
{
    public $status;
    public $name;
    public $phone;
    public $email;
    public $password;
    public $licence;
    public $freeday;
    public $vehicle_types_id;

    public $days_options = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miercoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        	['name', 'trim'],
            ['name', 'required'],

            ['phone', 'trim'],
            ['phone', 'required'],

            [['name'], 'string', 'max' => 60],

            [['licence'], 'string', 'max' => 15],
            [['phone'], 'string', 'max' => 25],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],

            [['freeday', 'status'], 'required'],

            [['freeday', 'status'], 'integer'],
            ['vehicle_types_id', 'safe'],
        ];
    }

    public function saveData($user)
    {
        $user->status = $this->status;
        $user->email = $this->email;
        $user->username = $this->email;
        if(!empty($this->password)) {
            $user->setPassword($this->password);
        }

        $user->profile->freeday = $this->freeday;
        $user->profile->name = $this->name;
        $user->profile->phone = $this->phone;
        $user->profile->licence = $this->licence;

        return $user->save() && $user->profile->save();
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
        
        $user = new User();
        $user->type = User::TYPE_OPERATOR;
        $user->status = $this->status;
        $user->email = $this->email;
        $user->username = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if($user->save()) {
        	$profile = new UserProfile();
        	$profile->user_id = $user->id;
            $profile->freeday = $this->freeday;
        	$profile->name = $this->name;
        	$profile->phone = $this->phone;
            $profile->licence = $this->licence;

        	if(!$profile->save()) {
        		$user->delete();
        		return $user;
        	}

            foreach ($this->vehicle_types_id as $vehicle_type_id) {
                $user->addVehicleType($vehicle_type_id);
            }
            

        	return $user;
        }

        return $user->save();

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Nombre'),
            'name' => Yii::t('app', 'Contacto'),
            'phone' => Yii::t('app', 'Teléfono'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Contraseña'),
            'licence' => Yii::t('app', 'Licencia'),
            'freeday' => Yii::t('app', 'Día de descanso'),
            'vehicle_types_id' => Yii::t('app', 'Tipos de vehículo que puede conducir'),
        ];
    }

    /**
     * Sends confirmation email to user
     * @param Client $user user model to with email should be send
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
