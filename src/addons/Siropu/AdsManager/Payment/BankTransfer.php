<?php

namespace Siropu\AdsManager\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;
use XF\Payment\CallbackState;

class BankTransfer extends \XF\Payment\AbstractProvider
{
	public function getTitle()
	{
		return \XF::phrase('siropu_ads_manager_bank_transfer_payment_title');
	}
     public function verifyConfig(array &$options, &$errors = [])
	{
          if (empty($options['account_name']))
          {
               $errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_bank_account_name');
          }

          if (empty($options['account_number']))
          {
               $errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_bank_account_number');
          }

          if (empty($options['swift_code']))
          {
               $errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_swift_code');
          }

          return true;
     }
     protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase)
	{
		return [
			'paymentProfile' => $purchase->paymentProfile,
			'purchase'       => $purchase
		];
	}
     public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
	{
          $viewParams = $this->getPaymentParams($purchaseRequest, $purchase);
		return $controller->view('Siropu\AdsManager:BankTransfer', 'siropu_ads_manager_payment_initiate_bank_transfer', $viewParams);
     }
     public function setupCallback(\XF\Http\Request $request)
	{
          $state = new CallbackState();

          return $state;
     }
     public function getPaymentResult(CallbackState $state)
	{
          $state->paymentResult = '';
     }
     public function prepareLogData(CallbackState $state)
	{

     }
     public function supportsRecurring(PaymentProfile $paymentProfile, $unit, $amount, &$result = self::ERR_NO_RECURRING)
	{
          return false;
     }
}
