<?php

namespace Rivals\CoinPayments\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;
use XF\Payment\CallbackState;

class CoinPayments extends \XF\Payment\AbstractProvider
{
	public function getTitle()
	{
		return 'CoinPayments';
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
		if (empty($options['public_key'])) {
			$errors[] = \XF::phrase('coinpayments_you_must_provide_public_key');
			return false;
		}

		if (empty($options['private_key'])) {
			$errors[] = \XF::phrase('coinpayments_you_must_provide_private_key');
			return false;
		}

		if (empty($options['currency_entry'])) {
			$errors[] = \XF::phrase('coinpayments_you_must_provide_currency_entry');
			return false;
		}

		if (empty($options['currency_exit'])) {
			$errors[] = \XF::phrase('coinpayments_you_must_provide_currency_exit');
			return false;
		}

		if (empty($options['amount'])) {
			$errors[] = \XF::phrase('coinpayments_you_must_provide_amount');
			return false;
		}

		if ($errors) {
			return false;
		}

		return true;
	}

	public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
	{
		$paymentProfile = $purchase->paymentProfile;
		$purchaser = $purchase->purchaser;

		$paymentProfile->title = $paymentProfile->display_title ? $paymentProfile->display_title : $paymentProfile->title;

		$keys = ['public_key' => $paymentProfile->options['public_key'], 'private_key' => $paymentProfile->options['private_key']];
		$response = $this->call($keys, 'create_transaction', [
			'amount' => $paymentProfile->options['amount'],
			'currency1' => $paymentProfile->options['currency_entry'],
			'currency2' => $paymentProfile->options['currency_exit'],
			'buyer_name' => \XF::visitor()->username,
			'buyer_email' => \XF::visitor()->email,
			'item_name' => $paymentProfile->title,
			'invoice' => $paymentProfile->title,
			'custom' => $purchaseRequest->request_key,
			'ipn_url' => $controller->buildLink('full:coinpayments/process')
		]);

		if (empty($response)) {
			throw $controller->exception($controller->error(\XF::phrase('coinpayments_error_no_response')));
		}

		$data = $response;

		if ($data->error !== 'ok') {
			$error = $this->getErrorMessage($data->error);
			throw $controller->exception($controller->error($error));
		}


		$viewParams = [
			'purchaseRequest' => $purchaseRequest,
			'paymentProfile' => $paymentProfile,
			'purchaser' => $purchase->purchaser,
			'purchase' => $purchase,
			'purchasableTypeId' => $purchase->purchasableTypeId,
			'qrcodeUrl' => $data->result->qrcode_url,
			'statusUrl' => $data->result->status_url,
			'confirmations' => $data->result->confirms_needed,
			'address' => $data->result->address,
			'amount' => $data->result->amount,
			'transactionId' => $data->result->txn_id,
			'tagId' => isset($data->result->dest_tag) ? $data->result->dest_tag : \XF::phrase('none'),
		];

		return $controller->view(null, 'payment_initiate_coinpayments', $viewParams);
	}

	public function setupCallback(\XF\Http\Request $request)
	{
		$state = new CallbackState();
		$state->transaction_id = $request->filter('transaction_id', 'str');
		return $state;
	}

	public function processPayment(Controller $controller, PurchaseRequest $purchaseRequest, PaymentProfile $paymentProfile, Purchase $purchase)
	{
		$response    = $controller->filter('response', 'array');
		$request  	 = $controller->request();
		$endpointUrl = $this->getApiEndpoint();

		if (!$controller->isLoggedIn()) {
			return $controller->noPermission();
		}

		if (!$request->get('transaction_id')) {
			$error = \XF::phrase('coinpayments_error_occured');
			throw $controller->exception($controller->error($error));
		}


		var_dump($purchase->returnUrl);
		exit;
		try {
			$keys = ['public_key' => $paymentProfile->options['public_key'], 'private_key' => $paymentProfile->options['private_key']];
			$response = $this->call($keys, 'get_tx_info', [
				'txid' => $request->get('transaction_id'),
				'full' => 1
			]);

			if (empty($response)) {
				throw $controller->exception($controller->error(\XF::phrase('coinpayments_error_no_response')));
			}




			$data = $response;

			if ($data->error !== 'ok') {
				$error = $this->getErrorMessage($data->error);
				throw $controller->exception($controller->error($error));
			}

			if ($data->result->checkout->custom !== $request->get('request_key')) {
				throw $controller->exception($controller->error(\XF::phrase('coinpayments_error_transaction_security')));
			}

			// #DEBUG $data->result->status = 1;

			if ($data->result->status == -1) {
				throw $controller->exception($controller->error(\XF::phrase('coinpayments_error_transaction_canceled')));
			}

			if ($data->result->status == 0) {
				throw $controller->exception($controller->error(\XF::phrase('coinpayments_error_transaction_pending')));
			}

			// success
			if ($data->result->status == 100) {
				$state = new CallbackState();
				$state->transaction_id = $request->filter($request->get('transaction_id'), 'str');
				$state->paymentResult = CallbackState::PAYMENT_RECEIVED;
				$state->purchaseRequest = $purchaseRequest;
				$state->paymentProfile = $paymentProfile;

				$this->completeTransaction($state);

				$this->log($state);
			}

			// invalid codes
			else {
				throw $controller->exception($controller->error(\XF::phrase('coinpayments_error_occured_invalid_payment', ['transaction_id' => $request->get('transaction_id')])));
			}
		} catch (\GuzzleHttp\Exception\RequestException $e) {
			\XF::logException($e, false, "CoinPayments error: ");

			throw $controller->exception($controller->error(\XF::phrase('something_went_wrong_please_try_again')));
		}



		return $controller->redirect($purchase->returnUrl);
	}

	public function getPaymentResult(CallbackState $state)
	{
		//
	}

	public function supportsRecurring(PaymentProfile $paymentProfile, $unit, $amount, &$result = self::ERR_NO_RECURRING)
	{
		return false;
	}

	public function prepareLogData(CallbackState $state)
	{
		$state->logDetails = $state->event;
		$state->logDetails['eventType'] = $state->eventType;
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

	public function call($keys, $cmd, $paymentParams)
	{
		$endpointUrl = $this->getApiEndpoint();

		$client = \XF::app()->http()->client();

		$publicKey = $keys['public_key'];
		$privateKey = $keys['private_key'];

		$params = ['version' => 1, 'format' => 'json'];
		$params += ['key' => $publicKey, 'cmd' => $cmd];

		foreach ($paymentParams as $key => $param) {
			$params[$key] = $param;
		}

		$hmac = hash_hmac('sha512', http_build_query($params, '', '&'), $privateKey);

		$response = $client->post($endpointUrl, [
			'headers' => ['HMAC' => $hmac],
			'form_params' => $params
		]);

		$data = $response->getBody()->getContents();
		$data = json_decode($data);

		return $data;
	}
}
