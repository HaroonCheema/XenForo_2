<?php

namespace FS\CoinPaymentsIntegrationNew\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;
use XF\Payment\CallbackState;

class CoinPaymentsNew extends \XF\Payment\AbstractProvider
{
	protected $proxyUrl = null;

	public function getTitle()
	{
		return 'CoinPayments';
	}

	public function getApiEndpoint()
	{
		return "https://a-api.coinpayments.net/api/v2/merchant/invoices";
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
		if (empty($options['client_id'])) {
			$errors[] = \XF::phrase('fs_coinpayments_you_must_provide_client_id');
			return false;
		}

		if (empty($options['client_secret'])) {
			$errors[] = \XF::phrase('fs_coinpayments_you_must_provide_client_secret');
			return false;
		}

		// if (empty($options['currency_exit'])) {
		// 	$errors[] = \XF::phrase('coinpayments_you_must_provide_currency_exit');
		// 	return false;
		// }

		if ($errors) {
			return false;
		}

		return true;
	}

	public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
	{
		$paymentProfile = $purchase->paymentProfile;
		$purchaser = $purchase->purchaser;

		$keys = ['client_id' => $paymentProfile->options['client_id'], 'client_secret' => $paymentProfile->options['client_secret']];

		$invoice = [
			'currency' => $purchase->currency,
			// 'currency' => $paymentProfile->options['currency_exit'],
			'items' => [
				[
					'name' => $purchase->title,
					'description' => $purchase->title,
					'quantity' => [
						'value' => 1,
						'type' => 'quantity'
					],
					'amount' => (string)$purchase->cost,
					'tax' => '0'
				]
			],
			'amount' => [
				'breakdown' => [
					'subtotal' => (string)$purchase->cost,
					'shipping' => '0',
					'handling' => '0',
					'taxTotal' => '0',
					'discount' => '0'
				],
				'total' => (string)$purchase->cost
			],
			'buyer' => [
				'name' => [
					'firstName' => $purchaser->username
				],
				'emailAddress' => $purchaser->email
			],
			'customData' => [
				'request_key' => $purchaseRequest->request_key
			],
			'requireBuyerNameAndEmail' => false,
			'isEmailDelivery' => false,
			'webhooks' => [
				[
					'notificationsUrl' => $this->getCallbackUrl(),
					'notifications' => ['invoiceCreated', 'invoicePending', 'invoicePaid', 'invoiceCompleted', 'invoiceCancelled', 'invoiceTimedOut']
				]
			],
			// 'useCoinReservation' => true,
			'merchantOptions' => [
				'showAddress' => false,
				'showEmail' => false,
				'showPhone' => false,
				'showRegistrationNumber' => false,
				'showTaxId' => false
			],
			'payment' => [
				'refundEmail' => $purchaser->email
			]
		];

		$response = $this->call($keys, $invoice);

		if (empty($response)) {
			throw $controller->exception($controller->error(\XF::phrase('fs_coinpayments_error_no_response')));
		}

		if (empty($response['invoices'][0]['checkoutLink'])) {
			throw $controller->exception($controller->error(\XF::phrase('fs_coinpayments_error_no_response')));
			// throw $controller->exception($controller->error(\XF::phrase('coinpayments_error_no_checkout_url')));
		}

		// if (empty($response) || !isset($response['error']) || $response['error'] !== 'ok') {
		//  $error = isset($response['error']) ? $this->getErrorMessage($response['error']) : \XF::phrase('coinpayments_error_no_response');
		//  throw $controller->exception($controller->error($error));
		// }

		$checkoutUrl = $response['invoices'][0]['checkoutLink'] . '&success-url=' . urlencode($purchase->returnUrl);

		if ($checkoutUrl) {
			return $controller->redirect($checkoutUrl, '');
		}
	}

	public function setupCallback(\XF\Http\Request $request)
	{
		$state = new CallbackState();

		$inputRaw = $request->getInputRaw();

		$callBackdata = json_decode($inputRaw, true);

		$state->inputRaw = $inputRaw;

		$state->_POST = $_POST;
		$state->inputs = $request->getInput();

		$state->transactionId = $callBackdata['id'] ?? "";
		$state->requestKey = $callBackdata['invoice']['customData']['request_key'] ?? "";
		$state->type = $callBackdata['type'] ?? "";
		$state->status = $callBackdata['invoice']['state'] ?? "";

		return $state;
	}

	public function validateCallback(CallbackState $state)
	{

		if (!$this->validateExpectedValues($state)) {
			$state->logType = 'error';
			$state->logMessage = 'Data received from ConPayments does not contain the expected values.';
			return false;
		}

		if (!$state->requestKey) {

			$state->logType = 'error';
			$state->logMessage = 'CoinPayments: Invalid purchase request.Request Key not found.';
			$state->httpCode = 404;

			return false;
		}

		if (!$state->transactionId) {

			$state->logType = 'error';
			$state->logMessage = 'CoinPayments: No transaction ID. No action to take.';
			$state->httpCode = 404;

			return false;
		}

		if (!$state->status || !in_array($state->type, ['InvoiceCreated', 'InvoicePending', 'InvoicePaid', 'InvoiceCompleted', 'InvoiceCancelled', 'InvoiceTimedOut'])) {

			$state->logType = 'error';
			$state->logMessage = 'CoinPayments:Invalid Event Type.';
			$state->httpCode = 404;

			return false;
		}

		if (!$state->getPurchaseRequest()) {

			$state->logType = 'error';
			$state->logMessage = 'CoinPayments: purchase request Not Found.';
			$state->httpCode = 404;

			return false;
		}

		if ($state->status != "Completed") {

			$state->logType = 'info';
			$state->logMessage = 'CoinPayments: Event "' . htmlspecialchars($state->status) . '" processed.';
			$state->httpCode = 200;

			return false;
		}

		return true;
	}


	protected function validateExpectedValues(CallbackState $state)
	{
		return ($state->getPurchaseRequest() && $state->getPaymentProfile());
	}

	public function getPaymentResult(CallbackState $state)
	{

		switch ($state->status) {
			case 'Completed':
				$state->paymentResult = CallbackState::PAYMENT_RECEIVED;
				break;
			case 'Unpaid':
				$state->logType = 'info';
				$state->logMessage = "invoice created, waiting for payment";
				$state->httpCode = 404;
				break;
			case 'Cancelled':
				$state->logType = 'info';
				$state->logMessage = "invoice cancelled";
				$state->httpCode = 404;
				break;
			case 'TimedOut':
				$state->logType = 'info';
				$state->logMessage = "invoice expired";
				$state->httpCode = 404;
				break;
			case 'Deleted':
				$state->logType = 'info';
				$state->logMessage = "invoice deleted";
				$state->httpCode = 404;
				break;
			case 'Pending':
				$state->logType = 'info';
				$state->logMessage = "payment detected on chain, waiting to be received by CPS";
				$state->httpCode = 404;
				break;
			default:
				$state->logType = 'info';
				$state->logMessage = "unknown status";
				$state->httpCode = 404;
				break;
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
			return \XF::phrase('fs_coinpayments_error_too_many_requests');
		} else {
			return \XF::phrase('fs_coinpayments_error_from_cointpayments') . ' ' . $message;
		}
	}

	public function call($keys, $paymentParams)
	{
		$client = \XF::app()->http()->client();

		$endpointUrl = $this->getApiEndpoint();
		$method = 'POST';
		$timestamp = gmdate('Y-m-d\TH:i:s');

		$clientId = $keys['client_id'];
		$clientSecret = $keys['client_secret'];

		$payload = json_encode($paymentParams, JSON_UNESCAPED_SLASHES);

		$message = "\u{FEFF}" . $method . $endpointUrl . $clientId . $timestamp . $payload;
		$signature = base64_encode(hash_hmac('sha256', $message, $clientSecret, true));

		$headers = [
			'Content-Type' => 'application/json',
			'Accept' => 'application/json',
			'X-CoinPayments-Client' => $clientId,
			'X-CoinPayments-Timestamp' => $timestamp,
			'X-CoinPayments-Signature' => $signature
		];

		try {
			$response = $client->post($endpointUrl, [
				'headers' => $headers,
				'body' => $payload
			]);

			$data = $response->getBody()->getContents();
			return json_decode($data, true);
		} catch (\Exception $ex) {
			throw new \RuntimeException('CoinPayments API call failed: ' . $ex->getMessage());
		}
	}
}
