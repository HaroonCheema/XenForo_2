<?php

namespace FS\CoinPaymentsIntegration\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;
use XF\Payment\CallbackState;

class CoinPayments extends \XF\Payment\AbstractProvider
{
	protected $proxyUrl = null;

	public function getTitle()
	{
		return 'CoinPaymentsLegacy';
		// return 'CoinPayments (Legacy)';
	}

	public function getApiEndpoint()
	{
		return "https://www.coinpayments.net/api.php";
	}

	public function getParams()
	{
		return [
			'version' => 1,
			'format' => 'json'
		];
	}

	public function verifyConfig(array &$options, &$errors = [])
	{
		if (empty($options['merchant_id'])) {
			$errors[] = \XF::phrase('coinpayments_you_must_provide_merchant_id');
			return false;
		}

		if (empty($options['public_key'])) {
			$errors[] = \XF::phrase('coinpayments_you_must_provide_public_key');
			return false;
		}

		if (empty($options['private_key'])) {
			$errors[] = \XF::phrase('coinpayments_you_must_provide_private_key');
			return false;
		}

		if (empty($options['currency_exit'])) {
			$errors[] = \XF::phrase('coinpayments_you_must_provide_currency_exit');
			return false;
		}

		if ($errors) {
			return false;
		}

		return true;
	}

	public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
	{

		// $proxyUrlOpt = \XF::options()->fsCoinPaymentsProxySite;
		// $this->proxyUrl = rtrim($proxyUrlOpt, '/') . '/payment.php';

		//$this->proxyUrl ='https://d6c9ed15ec32aec1f07a6fe610f6f2a2.com/payment.php';

		$paymentProfile = $purchase->paymentProfile;
		$purchaser = $purchase->purchaser;

		//		$paymentProfile->title = $paymentProfile->display_title ? $paymentProfile->display_title : $paymentProfile->title;

		$keys = ['public_key' => $paymentProfile->options['public_key'], 'private_key' => $paymentProfile->options['private_key']];
		$response = $this->call($keys, 'create_transaction', [
			'amount' => $purchase->cost,
			'currency1' => $purchase->currency,
			'currency2' => $paymentProfile->options['currency_exit'],
			'buyer_name' => $purchaser->username,
			'buyer_email' => $purchaser->email,
			'item_name' => $purchase->title,
			'invoice' => $purchase->title,
			'custom' => $purchaseRequest->request_key,
			'ipn_url' => $this->getCallbackUrl(),
			'success_url' => $purchase->returnUrl,
			'cancel_url' => $purchase->cancelUrl,

		]);



		if (empty($response)) {
			throw $controller->exception($controller->error(\XF::phrase('coinpayments_error_no_response')));
		}

		$data = $response;

		if ($data->error !== 'ok') {
			$error = $this->getErrorMessage($data->error);
			throw $controller->exception($controller->error($error));
		}

		$checkoutUrl = $data->result->checkout_url;

		if ($checkoutUrl) {
			return $controller->redirect($checkoutUrl, '');
		}
	}

	public function setupCallback(\XF\Http\Request $request)
	{
		$state = new CallbackState();

		$inputRaw = $request->getInputRaw();
		$state->inputRaw = $inputRaw;

		$state->_POST = $_POST;
		$state->inputs = $request->getInput();

		$state->hmacSignature = $request->getServer('HTTP_HMAC');


		//file_put_contents('coinPayments_debug_Post.txt', $state->_POST,FILE_APPEND);
		//file_put_contents('coinPayments_debug_Inputs.txt', $state->inputs,FILE_APPEND);

		$state->transactionId = $request->filter('txn_id', 'str');
		$state->requestKey = $request->filter('custom', 'str');

		return $state;
	}



	public function validateCallback(CallbackState $state)
	{

		if (!$this->validateExpectedValues($state)) {
			$state->logType = 'error';
			$state->logMessage = 'Data received from ConPayments does not contain the expected values.';
			return false;
		}


		$paymentProfile = $state->getPaymentProfile();
		$profileOptions = $paymentProfile->options;

		$cpMerchantId = $profileOptions['merchant_id'];
		$cpIpnSecret = $profileOptions['ipn_secret'];

		$postData = $state->_POST;



		if (!isset($postData['ipn_mode']) || $postData['ipn_mode'] != 'hmac') {
			$state->logType = 'CoinPayments IPN Error';
			$state->logMessage = 'IPN Mode is not HMAC.';
			return false;
		}

		if (empty($state->hmacSignature)) {
			$state->logType = 'CoinPayments IPN Error';
			$state->logMessage = 'HMAC signature not sent with IPN.';
			return false;
		}

		if ($cpMerchantId && !isset($postData["merchant"]) || $postData["merchant"] != trim($cpMerchantId)) {
			$state->logType = 'CoinPayments IPN Error';
			$state->logMessage = 'No or incorrect Merchant ID passed.';
			return false;
		}


		if ($cpIpnSecret)    // if IPN secret is set in paymentProfile (in xf AdminCP) then match this to 'HMAC Signature' verification
		{
			$hmac = hash_hmac("sha512", $state->inputRaw, trim($cpIpnSecret));

			if ($hmac != $state->hmacSignature) {
				$state->logType = 'CoinPayments IPN Error';
				$state->logMessage = 'HMAC signature does not match.';
				return false;
			}
		}


		return true;
	}


	public function validateTransaction(CallbackState $state)
	{
		if (!$state->requestKey) {
			$state->logType = 'info';
			$state->logMessage = 'No purchase request key. Unrelated payment, no action to take.';
			return false;
		}

		if (!$state->transactionId) {
			$state->logType = 'info';
			$state->logMessage = 'No transaction ID. No action to take.';
			return false;
		}

		return parent::validateTransaction($state);
	}


	protected function validateExpectedValues(CallbackState $state)
	{
		return ($state->getPurchaseRequest() && $state->getPaymentProfile());
	}



	public function validatePurchasableData(CallbackState $state)
	{
		$paymentProfile = $state->getPaymentProfile();

		$postData = $state->_POST;
		$buyerPaidCurrency = $postData['currency2'];

		$options = $paymentProfile->options;
		$currencyExit = $options['currency_exit'];



		$matched = false;
		if ($buyerPaidCurrency == $currencyExit) {
			$matched = true;
		}



		if (!$matched) {
			$state->logType = 'error';
			$state->logMessage = 'Invalid Paid Currency (not paid with ' . $currencyExit . ').';
			return false;
		}

		return true;
	}



	public function validateCost(CallbackState $state)
	{
		$purchaseRequest = $state->getPurchaseRequest();

		$currency = $purchaseRequest->cost_currency;
		$cost = $purchaseRequest->cost_amount;

		$amountPaid = null;
		$postData = $state->_POST;


		if ($postData['amount1']) {
			$amountPaid = $postData['amount1'];
		}

		if ($amountPaid !== null) {
			$costValidated = (
				$amountPaid >= $cost
				&& strtoupper($postData['currency1']) === $currency
			);

			if (!$costValidated) {
				$state->logType = 'error';
				$state->logMessage = 'Invalid cost amount';
				return false;
			}

			return true;
		}

		return true;
	}


	public function getPaymentResult(CallbackState $state)
	{

		$postData = $state->_POST;

		if ($postData['status'] >= 100)      // Payment completed successfully
		{
			$state->paymentResult = CallbackState::PAYMENT_RECEIVED;
		} else {
			$state->logType = 'info';

			if ($postData['status'] < 0)   // Failures/Errors (Cancelled / Timed Out)
			{
				$state->logMessage = 'Payment Cancelled / Timed Out';
			} else {
				$state->logMessage = 'Payment is Pending in some way.';
			}
		}
	}

	public function supportsRecurring(PaymentProfile $paymentProfile, $unit, $amount, &$result = self::ERR_NO_RECURRING)
	{
		return false;
	}

	public function prepareLogData(CallbackState $state)
	{
		$state->logDetails = $state->_POST;
	}



	public function getErrorMessage($message)
	{
		// hide ip address
		if (strpos($message, 'Too many errors in the') !== false) {
			return \XF::phrase('coinpayments_error_too_many_requests');
		} else {
			return \XF::phrase('coinpayments_error_from_cointpayments') . ' ' . $message;
		}
	}

	// ***** old code *******************
	public function call($keys, $cmd, $paymentParams)
	{

		$endpointUrl = $this->getApiEndpoint();

		$client = \XF::app()->http()->client();

		$publicKey = $keys['public_key'];
		$privateKey = $keys['private_key'];

		$params = [
			'version' => 1,
			'format' => 'json',
			'key' => $publicKey,
			'cmd' => $cmd
		];


		$params = array_merge($params, $paymentParams);

		$hmac = hash_hmac('sha512', http_build_query($params, '', '&'), $privateKey);


		try {
			$response = $client->post($endpointUrl, [
				'headers' => ['HMAC' => $hmac],
				'form_params' => $params
			]);

			$data = $response->getBody()->getContents();
			$data = json_decode($data);
		} catch (\Exception $ex) {
			throw $ex->getMessage();
			//             throw new \RuntimeException($ex->getMessage(), true);
			//            echo $exc->getTraceAsString();
		}
		return $data;
	}

	// ***** New code *******************

	// public function call($keys, $cmd, $paymentParams)
	// {

	// 	if(trim($this->proxyUrl) === "" || trim($this->proxyUrl) == '/payment.php')
	// 	{
	// 		// **** Old Code *****
	//         $endpointUrl = $this->getApiEndpoint();

	//         $client = \XF::app()->http()->client();

	//         $publicKey = $keys['public_key'];
	//         $privateKey = $keys['private_key'];

	//         $params = [
	//             'version' => 1,
	//             'format' => 'json',
	//             'key' => $publicKey,
	//             'cmd' => $cmd
	//         ];


	//         $params = array_merge($params, $paymentParams);

	//         $hmac = hash_hmac('sha512', http_build_query($params, '', '&'), $privateKey);


	//         try 
	//         {
	//             $response = $client->post($endpointUrl, [
	//                             'headers' => ['HMAC' => $hmac],
	//                             'form_params' => $params
	//                         ]);

	//             $data = $response->getBody()->getContents();
	//             $data = json_decode($data);

	//         } 
	//         catch (\Exception $ex) 
	//         {
	//             throw $ex->getMessage();
	// //             throw new \RuntimeException($ex->getMessage(), true);
	// //            echo $exc->getTraceAsString();
	//         }

	//         return $data;
	// 	}
	// 	else
	// 	{

	//     	//**** New code **** 
	// 	    $params = [
	// 	        'version' => 1,
	// 	        'format' => 'json',
	// 	        'key' => $keys['public_key'],
	// 	        'private_key' => $keys['private_key'],
	// 	        'cmd' => $cmd,
	// 	        'proxy_action' => 'api_call'
	// 	    ];

	// 	    $params = array_merge($params, $paymentParams);

	// 	    $queryString = http_build_query($params);
	// 	    $requestUrl = $this->proxyUrl . '?' . $queryString;

	// 	    $client = \XF::app()->http()->client();

	// 	    try
	// 	    {
	// 	        $response = $client->get($requestUrl, [
	// 	            'headers' => [
	// 	                'X-Proxy-Auth' => '66d4db93CdCb09ff7502eABa7f62566d0'
	// 	            ]
	// 	        ]);

	// 	        $data = $response->getBody()->getContents();
	// 	        return json_decode($data);
	// 	    }
	// 	    catch (\Exception $ex)
	// 	    {
	// 	        // \XF::logException($ex, false, 'CoinPayments proxy error (GET): ');
	// 	    }

	// 	 }

	// 	    return null;
	// }
}
