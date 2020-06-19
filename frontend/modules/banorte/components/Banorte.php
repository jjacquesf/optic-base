<?php

namespace frontend\modules\banorte\components;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

use \Yii;
use \Exception;
use yii\base\Component;
use frontend\modules\banorte\models\Payworks2ResponseForm;

class Banorte extends Component
{
    private $_card;
    private $_card_holder;
    private $_expires;
    private $_card_type;
    private $_cvv2;

    public $merchant_id;
    public $terminal_id;
    public $merchant_name;
    public $merchant_city;
    public $cert_3d;
    public $cert_3d_forward_path;
    public $mode;
    public $pw_username;
    public $pw_password;

    public function setCard($card, $card_holder, $expires, $card_type, $cvv2) {
        $this->_card = $card;
        $this->_card_holder = $card_holder;
        $this->_expires = $expires;
        $this->_card_type = $card_type;
        $this->_cvv2 = $cvv2;
    }

    public function makePayworks2Request($total, $status_3d = null, $eci = null, $xid = null, $cavv = null) {
        $client = new Client([
            'base_uri' => 'https://via.pagosbanorte.com/payw2',
            'timeout'  => 2.0,
        ]);

        try {

            $params = [
                'MERCHANT_ID' => Yii::$app->banorte->merchant_id,
                'USER' => Yii::$app->banorte->pw_username,
                'PASSWORD' => Yii::$app->banorte->pw_password,
                'CMD_TRANS' => 'VENTA',
                'TERMINAL_ID' => Yii::$app->banorte->terminal_id,
                'AMOUNT' => number_format($total, 2, '.', ''),
                'MODE' => Yii::$app->banorte->mode,
                // 'REFERENCE' => $this->_card,
                // 'CONTROL_NUMBER' => $this->_card,
                // 'CUSTOM ER_REF1' => $this->_card,
                // 'CUSTOM ER_REF2' => $this->_card,
                // 'CUSTOM ER_REF3' => $this->_card,
                // 'CUSTOM ER_REF4' => $this->_card,
                // 'CUSTOM ER_REF5' => $this->_card,
                'CARD_NUMBER' => $this->_card,
                'CARD_EXP' => $this->_expires,
                'SECURITY_CODE' => $this->_cvv2,
                'ENTRY_MODE' => 'MANUAL',
                // 'GROUP' => $this->_card,
                'RESPONSE_LANGUAGE' => 'EN',
            ];

            if($status_3d != null) $params['STATUS_3D'] = $status_3d;
            if($eci != null) $params['ECI'] = $eci;
            if($xid != null) $params['XID'] = $xid;
            if($xid != null) $params['CAVV'] = $cavv;

            $response = $client->request('POST', 'https://via.pagosbanorte.com/payw2', [ 'form_params' => $params ]);

            $header_keys = ['MERCHANT_ID', 'REFERENCE', 'CONTROL_NUMBER', 'CUST_REQ_DATE', 'AUTH_REQ_DATE', 'AUTH_RSP_DATE', 'CUST_RSP_DATE', 'PAYW_RESULT', 'AUTH_RESULT', 'PAYW_CODE', 'AUTH_CODE', 'TEXT', 'CARD_HOLDER', 'ISSUING_BANK', 'CARD_BRAND', 'CARD_TYP'];
            $data = [];
            foreach ($header_keys as $hk) {
                if ($response->hasHeader($hk)) {
                    $data[$hk] = $response->getHeader($hk)[0];
                }
            }

            @mail('jjacquesf@gmail.com', 'Payworks Response', json_encode($params) . "\n\n" . implode("\n", $data));

            $model = new Payworks2ResponseForm();
            $model->load($data, '');
            return $model;
        } catch (RequestException $e) {
            
            // if ($e->hasResponse()) {
            //     return false;
            // }

            return false;
        }
    }

    public function uniqidReal($lenght = 15) {
        // uniqid gives 15 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}