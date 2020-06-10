<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\QuoteForm;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionQuote()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new QuoteForm();
        if($model->load(Yii::$app->request->get(), '') && $model->validate()) {
            
            return [
                'success' => true,
                'data' => $model->quote(),
            ];
        }

        return ['success' => false];
    }

    public function actionBook()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new QuoteForm();
        $model->scenario = QuoteForm::SCENARIO_BOOK;
        if($model->load(Yii::$app->request->post()) 
            && $model->validate()) {

            $booking = $model->book();

            if($booking->client != null) {
                Yii::$app->mailer
                    ->compose(
                        ['html' => 'booking-html', 'text' => 'booking-text'],
                        ['booking' => $booking]
                    )
                    ->setTo($booking->client->email)
                    ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                    ->setReplyTo([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                    ->setSubject(Yii::t('app', 'Reservación') . ' ' . $booking->reference)
                    // ->setTextBody($this->body)
                    ->send();
            }

                
            return [
                'success' => true,
                'data' => $booking,
            ];
        } else {
            return $model->getErrors();
        }

        return ['success' => false];
    }

    /**
    * @inheritdoc
    */
    public function beforeAction($action)
    {            
      if ($action->id == 'paypal-ipn') {
          $this->enableCsrfValidation = false;
      }

      return parent::beforeAction($action);
    }

    /**
     * Paypal IPN.
     *
     * @return mixed
     */
    public function actionPaypalIpn()
    {
        // Validate post request
        //$listener->requirePostMethod();

        // $_POST = (array) json_decode('{"mc_gross":"370.01.00","protection_eligibility":"Eligible","address_status":"unconfirmed","item_number1":"","tax":"0.00","item_number2":"","payer_id":"R7EAN4CLRBQRL","address_street":"Calle Juarez 1","payment_date":"17:44:12 May 04, 2015 PDT","payment_status":"Completed","charset":"windows-1252","address_zip":"11580","mc_shipping":"0.00","mc_handling":"0.00","first_name":"Comprador","mc_fee":"23.28","address_country_code":"MX","address_name":"Comprador Fashion Zone","notify_version":"3.8","custom":"29","payer_status":"verified","business":"vendedor@fashionzone.com.mx","address_country":"Mexico","num_cart_items":"2","mc_handling1":"0.00","mc_handling2":"0.00","address_city":"Miguel Hidalgo","verify_sign":"AJdvZnAElO.KLz0lzCVaXF7q8Yb9A76selImIl8x3gODxEw86imOY3h6","payer_email":"comprador@fashionzone.com.mx","mc_shipping1":"0.00","mc_shipping2":"0.00","tax1":"0.00","tax2":"0.00","txn_id":"5VV760049B618681N","payment_type":"instant","last_name":"Fashion Zone","address_state":"Ciudad de Mexico","item_name1":"TBTNARTAA2H","receiver_email":"vendedor@fashionzone.com.mx","item_name2":"PUTNNGUNA3U","payment_fee":"","quantity1":"1","quantity2":"1","receiver_id":"MHAW22797VZ2Y","txn_type":"cart","mc_gross_1":"850","mc_currency":"MXN","mc_gross_2":"177.00","residence_country":"MX","test_ipn":"1","transaction_subject":"2300","payment_gross":"","ipn_track_id":"f65ac1d570292"}');

        $ipn="REQUEST\n";
        if(!empty($_POST)) {
            $ipn .= json_encode($_POST);
        }

        @mail('jjacquesf@gmail.com', 'Optic IPN Request', $ipn);

        if (($result = Yii::$app->paypalEC->processIpn($_POST))) {

            // $order = Order::find()->where([ 'reference' => $result['custom'] ])->one();
            // if(!is_null($order)) {

            //     if($order->addPayment(Order::PAYMENT_METHOD_PAYPAL, $result['amount'], $result['txn_id'], Payment::STATUS_ACTIVE, $result['comments'])) {
            //         return true;
            //     }
            // }
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
