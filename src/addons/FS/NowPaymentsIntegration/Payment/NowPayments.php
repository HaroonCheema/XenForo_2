<?php

namespace FS\NowPaymentsIntegration\Payment;

use Exception;
use XF;
use XF\Entity\PurchaseRequest;
use XF\Http\Request;
use XF\Mvc\Controller;
use XF\Payment\AbstractProvider;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

class NowPayments extends AbstractProvider
{
	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return '[FS] NowPayments';
	}
	/**
	 * @return string
	 */
	public function getApiEndpoint(): string
	{
		// return 'https://api-sandbox.nowpayments.io/v1/';
		return 'https://api.nowpayments.io/v1/';
	}
	/**
	 * @param array $options
	 * @param array $errors
	 *
	 * @return bool
	 */
	public function verifyConfig(array &$options, &$errors = []): bool
	{
		if (empty($options['api_key']) || empty($options['secret_key'])) {
			$errors[] = XF::phrase('fs_you_must_provide_all_data');
			return false;
		}
		return true;
	}
	/**
	 * @param PurchaseRequest $purchaseRequest
	 * @param Purchase        $purchase
	 *
	 * @return array
	 */
	protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase): array
	{
		$profileOptions = $purchase->paymentProfile->options;
		$ipnURL = $profileOptions['ipn_urln'];
		return [
			'price_amount'      => $purchase->cost,
			'price_currency'    => $purchase->currency,
			'order_id'          => $purchaseRequest->request_key,
			'order_description' => 'Purchase of ' . $purchase->title,
			'ipn_callback_url'  => $ipnURL,
			'is_fee_paid_by_user' => 'true'
		];
	}
	public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase): XF\Mvc\Reply\AbstractReply
	{
		$profileOptions = $purchase->paymentProfile->options;
		$apiKey = $profileOptions['api_key'];
		$payment = $this->getPaymentParams($purchaseRequest, $purchase);
		$headers = [
			'x-api-key' => $apiKey,
			'Content-Type' => 'application/json'
		];
		$body = json_encode($payment);
		try {
			$response = XF::app()->http()->client()->post($this->getApiEndpoint() . 'invoice', [
				'headers' => $headers,
				'body' => $body
			]);
		} catch (Exception $e) {
			XF::logException($e);
			return $controller->error(XF::phrase('something_went_wrong_please_try_again'));
		}
		if ($response) {
			$responseData = json_decode($response->getBody()->getContents(), true);
			if (!empty($responseData['invoice_url'])) {
				return $controller->redirect($responseData['invoice_url']);
			} else {
				//\XF::logError('Invoice URL (invoice_url) not found in [FS] NowPayments response.');
			}
		}
		return $controller->error(XF::phrase('something_went_wrong_please_try_again'));
	}
	/**
	 * @param Request $request
	 * @return CallbackState
	 */
	public function setupCallback(Request $request): CallbackState
	{

		$state = new CallbackState();

		$state->providerId = $request->filter('_xfProvider', 'str');

		$state->rawInput = file_get_contents('php://input');

		$headers = [
			'X-NOWPAYMENTS-SIG' => $request->getServer('HTTP_X_NOWPAYMENTS_SIG'),
			'Content-Type' => $request->getServer('CONTENT_TYPE'),
		];

		if (!empty($state->rawInput)) {
			try {
				$rawData = json_decode($state->rawInput, true);
				if (json_last_error() === JSON_ERROR_NONE) {
					$state->input = $rawData;
				} else {
					$state->input = [];
				}
			} catch (Exception $e) {
				$state->input = [];
			}
		} else {
			$state->input = [];
		}

		$state->transactionId = $state->input['payment_id'] ?? null;
		$state->requestKey = $state->input['order_id'] ?? null;
		$state->amount = $state->input['price_amount'] ?? null;
		$state->currency = $state->input['price_currency'] ?? null;
		$state->status = $state->input['payment_status'] ?? null;

		$state->signature = $request->getServer('HTTP_X_NOWPAYMENTS_SIG');

		$state->ip = $request->getIp();

		$state->httpCode = 200;

		return $state;
	}
	/**
	 * @param CallbackState $state
	 * @return bool
	 */
	public function validateCallback(CallbackState $state): bool
	{

		if (!$state->transactionId || !$state->requestKey) {

			$state->logType = 'info';
			$state->logMessage = 'No payment_id or order_id provided';
			return false;
		}

		if ($state->getPaymentProfile()->provider_id != $state->providerId) {


			$state->logType = 'info';
			$state->logMessage = 'Invalid provider';
			return false;
		}

		return parent::validateCallback($state);
	}

	/**
	 * @param CallbackState $state
	 * @return bool
	 */
	public function validatePurchasableData(CallbackState $state): bool
	{
		$paymentProfile = $state->getPaymentProfile();
		$options = $paymentProfile->options;

		if (empty($options['secret_key'])) {
			$state->logType = 'error';
			$state->logMessage = 'No IPN secret key configured';
			return false;
		}

		if (empty($state->signature)) {
			$state->logType = 'error';
			$state->logMessage = 'No signature provided in request';
			return false;
		}

		$inputData = $state->input;
		ksort($inputData);
		$sortedJson = json_encode($inputData);

		$calculatedHmac = hash_hmac('sha512', $sortedJson, trim($options['secret_key']));

		if (!hash_equals($calculatedHmac, $state->signature)) {
			$state->logType = 'error';
			$state->logMessage = 'HMAC signature validation failed';
			return false;
		}

		return true;
	}

	/**
	 * @param CallbackState $state
	 */
	public function getPaymentResult(CallbackState $state): void
	{
		$status = strtolower($state->status);

		switch ($status) {
			case 'finished':
			case 'confirmed':
				$state->paymentResult = CallbackState::PAYMENT_RECEIVED;
				break;

			case 'failed':
			case 'expired':
				$state->paymentResult = CallbackState::PAYMENT_REINSTATED;
				break;

			case 'waiting':
			case 'confirming':
			case 'sending':
				$state->logType = 'info';
				$state->logMessage = "payment detected on chain, waiting to be received by CPS";
				$state->httpCode = 404;
				// $state->paymentResult = CallbackState::PAYMENT_PENDING;
				break;

			default:
				$state->logType = 'info';
				$state->logMessage = "unknown status";
				$state->httpCode = 404;
				// $state->paymentResult = CallbackState::PAYMENT_OTHER;
				break;
		}
	}

	/**
	 * @param CallbackState $state
	 */
	public function prepareLogData(CallbackState $state): void
	{
		$state->logDetails = [
			'ip' => $state->ip,
			'payment_id' => $state->transactionId,
			'order_id' => $state->requestKey,
			'status' => $state->status,
			'amount' => $state->amount,
			'currency' => $state->currency,
			'request_time' => \XF::$time,
			'raw_input' => $state->rawInput
		];
	}
}
