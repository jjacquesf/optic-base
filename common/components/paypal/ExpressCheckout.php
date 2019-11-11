<?php

namespace common\components\paypal;

use Yii;
use yii\base\Component;
use \Exception;

class ExpressCheckout extends Component
{

	public $sandbox = true;

	public $host_sandbox = 'www.sandbox.paypal.com';
	public $url_sandbox = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	public $email_sandbox = 'vendedor.jhackes@gmail.com';

	public $host = 'www.paypal.com';
	public $url = 'https://www.paypal.com/cgi-bin/webscr';

	public $business_account;

	public $ipn_url;
	public $cancel_url;
	public $success_url;
	public $error_url;

	public $currency_code;

	private $_items;
	private $_shipping_cost;
	private $_discount;
	private $_custom;

	public function processIpn($data)
	{
        $ipn = new PaypalIPN();

        if(Yii::$app->paypalEC->sandbox) {
        	$ipn->useSandbox();
        }

        try {
            
            if ($ipn->verifyIPN() && $data['payment_status'] === 'Completed') {

				$amount = (float) $data['mc_gross'];
				$custom = (string) $data['custom'];
				$txn_id = (string) $data['txn_id'];

				return [
					'custom' => $custom,
					'amount' => $amount,
					'txn_id' => $txn_id,
					'comments' => $comments,
				];
            }

        } catch (Exception $e) { return false;  }

        return false;
	}
	
	public function addItem($qty, $name, $amount)
	{
		$this->_items[] = [
			'qty' => $qty,
			'name' => $name,
			'amount' => $amount,
			'shipping' => 0,
		];
	}

	public function setShippingCost($amount)
	{
		$this->_shipping_cost = $amount;

		$items = [];
		$sic = $this->_shipping_cost / count($this->_items);
		foreach($this->_items as $item) {
			$items[] = [
				'qty' => $item['qty'],
				'name' => $item['name'],
				'amount' => $item['amount'],
				'shipping' => $sic,
			];
		}

		$this->_items = $items;
	}

	public function getItems()
	{
		return $this->_items;
	}

	public function getDiscount()
	{
		return $this->_discount;
	}

	public function setDiscount($amount)
	{
		$this->_discount = $amount;
	}

	public function getCustom($custom)
	{
		return $this->_custom;
	}

	public function setCustom($custom)
	{
		$this->_custom = $custom;
	}

	public function getEndPoint()
	{
		$paypal_url = $this->url;
		if($this->sandbox) {
			$paypal_url = $this->url_sandbox;
		}

		return $paypal_url;
	}

	// public function render()
	// {

	// 	$paypal_url = $this->url;
	// 	if($this->sandbox) {
	// 		$paypal_url = $this->url_sandbox;
	// 	}

	// 	return $this->render('express_checkout', [
	// 		'items' => $this->_items,
	// 		'custom' => $this->_custom,

	// 		'currency_code' => $this->currency_code,
	// 		'discount' => $this->_discount,
	// 		'business_account' => $this->business_account,
	// 		'ipn_url' => $this->ipn_url,
	// 		'cancel_url' => $this->cancel_url,
	// 		'success_url' => $this->success_url,
	// 		'error_url' => $this->error_url,

	// 		'paypal_url' => $paypal_url,
	// 	], false);
	// }
}
