<?php

namespace frontend\modules\banorte\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use frontend\modules\banorte\models\CardForm;
use frontend\modules\banorte\models\Cert3dResponseForm;
use common\models\Travel;
use common\models\TravelPayment;
/**
 * Default controller for the `catalog` module
 */
class DefaultController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', '3d-secure', '3d-secure-response'],
                'rules' => [
                    [
                        'actions' => ['index', '3d-secure', '3d-secure-response'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex() {
        
    }

    /**
    * @inheritdoc
    */
    public function beforeAction($action)
    {            
      if ($action->id == '3d-secure-response') {
          $this->enableCsrfValidation = false;
      }

      return parent::beforeAction($action);
    }

    public function action3dSecure($travel_id) {
        // $this->layout = '//clean';

        Yii::$app->session->setFlash('special-class', 'non-fixed');

        $model = Travel::findOne($travel_id);
        $cardModel = new CardForm();
        if ($model != null && $cardModel->load(Yii::$app->request->post()) && $cardModel->validate()) {
            Yii::$app->session->setFlash('cardModel', $cardModel);
            return $this->render('3d_secure', [
                'model' => $model,
                'cardModel' => $cardModel,
                'response_url' => Yii::$app->banorte->cert_3d_forward_path . $model->id,
                'total' => $model->total,
            ]);

        } else {
            return $this->redirect(['/site/index']);
        }
    }

    public function action3dSecureResponse($travel_id) {
        $this->layout = '//clean';

        $model = Travel::findOne($travel_id);
        
        if ($model != null) {
            
            Yii::$app->session->set('auth-travel-detail-id', $model->id);
            @mail('jjacquesf@gmail.com', '3DSecure Response', json_encode(Yii::$app->request->post()));

            $responseModel = new Cert3dResponseForm();
            if($responseModel->load(Yii::$app->request->post(), '')) {

                if($responseModel->validate()) {
                    $cardModel = Yii::$app->session->getFlash('cardModel', false);
                    if($cardModel) {
                        Yii::$app->banorte->setCard($cardModel->card, $cardModel->card_holder, $cardModel->expires, $cardModel->card_type, $cardModel->cvv);
                        $payworks2Response = Yii::$app->banorte->makePayworks2Request($model->total, $responseModel->Status, $responseModel->ECI, $responseModel->XID, $responseModel->CAVV);
                        if($payworks2Response->validate()) {
                            $payment = $model->addPayment(TravelPayment::TYPE_CC, $model->total, $payworks2Response->getFormatted('payw_details'));
                            Yii::$app->session->setFlash('payment-success', $payworks2Response->getFormatted('payw_result'));
                        } else {
                            Yii::$app->session->setFlash('payment-error', $payworks2Response->getFormatted('payw_result'));
                        }
                    } else {
                        Yii::$app->session->setFlash('payment-error', Yii::t('app', 'No se ha completado el pago. Intentalo con otra tarjeta.'));  
                    }
                } else {
                    Yii::$app->session->setFlash('payment-error', $responseModel->getErrorMessage($responseModel->Status));   
                }
                
            } else {
                Yii::$app->session->setFlash('payment-error', Yii::t('app', 'No se ha completado el pago. Intentalo con otra tarjeta.'));
            }

            return $this->redirect([
                '/site/travel-detail',
                'id' => $model->id
            ]);

        }

        return $this->redirect(['/site/index']);
    }
}
