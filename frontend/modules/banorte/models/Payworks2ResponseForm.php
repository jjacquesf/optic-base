<?php
namespace frontend\modules\banorte\models;

use Yii;
use yii\base\Model;

/**
 * Payworks2ResponseForm
 */
class Payworks2ResponseForm extends Model
{
    public $MERCHANT_ID;
    public $REFERENCE;
    public $CONTROL_NUMBER;
    public $CUST_REQ_DATE;
    public $AUTH_REQ_DATE;
    public $AUTH_RSP_DATE;
    public $CUST_RSP_DATE;
    public $PAYW_RESULT;
    public $AUTH_RESULT;
    public $PAYW_CODE;
    public $AUTH_CODE;
    public $TEXT;
    public $CARD_HOLDER;
    public $ISSUING_BANK;
    public $CARD_BRAND;
    public $CARD_TYPE;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MERCHANT_ID', 'REFERENCE', 'CONTROL_NUMBER', 'CUST_REQ_DATE', 'AUTH_REQ_DATE', 'AUTH_RSP_DATE', 'CUST_RSP_DATE', 'PAYW_RESULT', 'AUTH_RESULT', 'PAYW_CODE', 'AUTH_CODE', 'TEXT', 'CARD_HOLDER', 'ISSUING_BANK', 'CARD_BRAND', 'CARD_TYPE'], 'safe'],
            [['PAYW_RESULT'], 'compare', 'compareValue' => 'A'], // Approved
        ];
    }

    public function getFormatted($attribute)
    {

        switch($attribute) {
            case 'payw_result':
                switch($this->PAYW_RESULT) {
                    case 'A':
                        return Yii::t('app', 'Aprobado. El pago se ha acreditado.');
                    break;
                    case 'D':
                        return Yii::t('app', 'Declinado. El pago ha sido declicano por el banco emisor.');
                    break;
                    case 'R':
                        return Yii::t('app', 'Rechazada. El pago ha sido rechazado por el banco emisor.');
                    break;
                    case 'T':
                        return Yii::t('app', 'Sin respuesta del autorizador');
                    break;
                }
            case 'payw_details':
                $details = [];
                $details[] = Yii::t('app', 'Resultado') . " : %s";
                $details[] = Yii::t('app', 'Referencia') . " : %s";
                $details[] = Yii::t('app', 'Num. de control') . " : %s";
                $details[] = Yii::t('app', 'Solicitada') . " : %s";
                $details[] = Yii::t('app', 'Autorizada') . " : %s";
                $details[] = Yii::t('app', 'Cod. Autorización') . " : %s";
                return sprintf(implode("\n", $details), $this->getFormatted('payw_result'), $this->REFERENCE, $this->CONTROL_NUMBER, $this->CUST_REQ_DATE, $this->AUTH_REQ_DATE, $this->AUTH_CODE);
            break;
        }

        return '';
    }
    

}