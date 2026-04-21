<?php
namespace TheJavaSea2024\NowPaymentsAPI\Payment;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use XF;
use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Http\Request;
use XF\Mvc\Controller;
use XF\Mvc\Reply\AbstractReply;
use XF\Payment\AbstractProvider;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

class NowPaymentsAPI extends AbstractProvider
{
    // ... TheJavaSea - Technology World - Developer: Marks-Man

   /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'NowPaymentsAPI';
    }
    /**
     * @return string
     */
    public function getApiEndpoint(): string
    {
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
        if (empty($options['api_key']) || empty($options['secret_key']))
        {
            $errors[] = XF::phrase('javasea_you_must_provide_all_data');
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
        'order_description' => 'Purchase of ' . $purchase->title,     // Optional description
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
    try
    {
        $response = XF::app()->http()->client()->post($this->getApiEndpoint() . 'invoice', [
            'headers' => $headers,
            'body' => $body
        ]);
    }
    catch (Exception $e)
    {
        XF::logException($e);
        return $controller->error(XF::phrase('something_went_wrong_please_try_again'));
    }
    if ($response)
    {
        $responseData = json_decode($response->getBody()->getContents(), true);
        //\XF::logError('NowPayments response: ' . json_encode($responseData));
        if (!empty($responseData['invoice_url']))
        {
            return $controller->redirect($responseData['invoice_url']);
        }
        else
        {
            //\XF::logError('Invoice URL (invoice_url) not found in NowPayments response.');
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
        //\XF::logError('NowPayments setupCallback - Starting callback processing');
        
        $state = new CallbackState();
        
        $state->providerId = $request->filter('_xfProvider', 'str');
        
        // Get the raw input properly
        $state->rawInput = file_get_contents('php://input');
        //\XF::logError('NowPayments setupCallback - Raw Input: ' . $state->rawInput);
        
        // Log important headers individually
        $headers = [
            'X-NOWPAYMENTS-SIG' => $request->getServer('HTTP_X_NOWPAYMENTS_SIG'),
            'Content-Type' => $request->getServer('CONTENT_TYPE'),
        ];
        //\XF::logError('NowPayments setupCallback - Request Headers: ' . json_encode($headers));
        
        // Parse the JSON input if it exists
        if (!empty($state->rawInput)) {
            try {
                $rawData = json_decode($state->rawInput, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $state->input = $rawData;
                    //\XF::logError('NowPayments setupCallback - Parsed Input: ' . json_encode($rawData));
                } else {
                    //\XF::logError('NowPayments setupCallback - JSON Parse Error: ' . json_last_error_msg());
                    $state->input = [];
                }
            } catch (Exception $e) {
                //\XF::logError('NowPayments setupCallback - JSON Parse Exception: ' . $e->getMessage());
                $state->input = [];
            }
        } else {
            //\XF::logError('NowPayments setupCallback - No raw input received');
            $state->input = [];
        }
        
        // Set important fields from the parsed data
        $state->transactionId = $state->input['payment_id'] ?? null;
        $state->requestKey = $state->input['order_id'] ?? null;
        $state->amount = $state->input['price_amount'] ?? null;
        $state->currency = $state->input['price_currency'] ?? null;
        $state->status = $state->input['payment_status'] ?? null;
        

        
        // Get the signature from server variables
        $state->signature = $request->getServer('HTTP_X_NOWPAYMENTS_SIG');
        //\XF::logError('NowPayments setupCallback - Signature from header: ' . ($state->signature ?: 'NOT FOUND'));
        
        $state->ip = $request->getIp();
        //\XF::logError('NowPayments setupCallback - IP Address: ' . $state->ip);
        
        $state->httpCode = 200;
        
        return $state;
    }
    /**
     * @param CallbackState $state
     * @return bool
     */
 public function validateCallback(CallbackState $state): bool
    {
        //\XF::logError('NowPayments validateCallback - Starting validation');
        
        if (!$state->transactionId || !$state->requestKey)
        {

            $state->logType = 'info';
            $state->logMessage = 'No payment_id or order_id provided';
            return false;
        }

        if ($state->getPaymentProfile()->provider_id != $state->providerId)
        {

            
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

        if (empty($options['secret_key']))
        {
            $state->logType = 'error';
            $state->logMessage = 'No IPN secret key configured';
            return false;
        }

        if (empty($state->signature))
        {
            $state->logType = 'error';
            $state->logMessage = 'No signature provided in request';
            return false;
        }

        // Get the raw input data and sort it
        $inputData = $state->input;
        ksort($inputData);
        $sortedJson = json_encode($inputData);

        // Generate HMAC signature
        $calculatedHmac = hash_hmac('sha512', $sortedJson, trim($options['secret_key']));

        // Compare signatures
        if (!hash_equals($calculatedHmac, $state->signature))
        {
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
                $state->paymentResult = CallbackState::PAYMENT_FAILED;
                break;

            case 'waiting':
            case 'confirming':
            case 'sending':
                $state->paymentResult = CallbackState::PAYMENT_PENDING;
                break;

            default:
                $state->paymentResult = CallbackState::PAYMENT_OTHER;
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
