<?php

namespace Siropu\AdsManager\Purchasable;

use XF\Purchasable\Purchase;
use XF\Purchasable\AbstractPurchasable;
use XF\Payment\CallbackState;

class Advertising extends AbstractPurchasable
{
	public function getTitle()
	{
		return \XF::phrase('siropu_ads_manager_advertising');
	}
	public function getPurchaseFromRequest(\XF\Http\Request $request, \XF\Entity\User $purchaser, &$error = null)
	{
		$profileId      = $request->filter('payment_profile_id', 'uint');
		$paymentProfile = \XF::em()->find('XF:PaymentProfile', $profileId);

		if (!$paymentProfile || !$paymentProfile->active)
		{
			$error = \XF::phrase('please_choose_valid_payment_profile_to_continue_with_your_purchase');
			return false;
		}

		$invoiceId = $request->filter('invoice_id', 'uint');
		$invoice   = \XF::em()->find('Siropu\AdsManager:Invoice', $invoiceId);

		if ($request->filter('recurring', 'bool'))
		{
			$invoice->recurring = 1;
			$invoice->save();
		}

		if (!$invoice || !$invoice->canPay())
		{
			$error = \XF::phrase('do_not_have_permission');
			return false;
		}

		return $this->getPurchaseObject($paymentProfile, $invoice, $purchaser);
	}
	public function getPurchasableFromExtraData(array $extraData)
	{
		$output = [
			'link'        => '',
			'title'       => '',
			'purchasable' => null
		];

		$invoice = \XF::em()->find('Siropu\AdsManager:Invoice', $extraData['invoice_id']);

		if ($invoice)
		{
			$output['link']        = \XF::app()->router('admin')->buildLink('ads-manager/invoices/edit', $invoice);
			$output['title']       = $invoice->invoice_id;
			$output['purchasable'] = $invoice;
		}

		return $output;
	}
	public function getPurchaseFromExtraData(array $extraData, \XF\Entity\PaymentProfile $paymentProfile, \XF\Entity\User $purchaser, &$error = null)
	{
		$invoice = $this->getPurchasableFromExtraData($extraData);

		if (!$invoice['purchasable'] || !$invoice['purchasable']->canPay())
		{
			$error = \XF::phrase('do_not_have_permission');
			return false;
		}

		return $this->getPurchaseObject($paymentProfile, $invoice['purchasable'], $purchaser);
	}

	/**
	 * @param \XF\Entity\PaymentProfile $paymentProfile
	 * @param \XF\Entity\UserUpgrade $purchasable
	 * @param \XF\Entity\User $purchaser
	 *
	 * @return Purchase
	 */
	public function getPurchaseObject(\XF\Entity\PaymentProfile $paymentProfile, $purchasable, \XF\Entity\User $purchaser)
	{
		$purchase = new Purchase();

		$purchase->title             = \XF::phrase('siropu_ads_manager_advertising')->render();
		$purchase->description       = $purchaser->username;
		$purchase->cost              = $purchasable->cost_amount;
		$purchase->currency          = $purchasable->cost_currency;
		$purchase->recurring         = ($purchasable->recurring && $purchasable->length_unit);
		$purchase->lengthAmount      = $purchasable->length_amount;
		$purchase->lengthUnit        = $purchasable->length_unit;
		$purchase->purchaser         = $purchaser;
		$purchase->paymentProfile    = $paymentProfile;
		$purchase->purchasableTypeId = $this->purchasableTypeId;
		$purchase->purchasableId     = $purchasable->invoice_id;
		$purchase->purchasableTitle  = \XF::phrase('siropu_ads_manager_invoice_id')->render() . ': ' . $purchasable->invoice_id;
		$purchase->extraData         = [
               'invoice_id'  => $purchasable->invoice_id,
               'ads_manager' => true
          ];

		$router = \XF::app()->router('public');

		$purchase->returnUrl = $router->buildLink('canonical:ads-manager/success');
		$purchase->cancelUrl = $router->buildLink('canonical:ads-manager/invoices');

		return $purchase;
	}
	public function completePurchase(CallbackState $state)
	{
		$purchaseRequest = $state->getPurchaseRequest();
		$invoiceId       = $purchaseRequest->extra_data['invoice_id'];

		$paymentResult   = $state->paymentResult;
		$purchaser       = $state->getPurchaser();

		$invoice = \XF::em()->find('Siropu\AdsManager:Invoice', $invoiceId);

		switch ($paymentResult)
		{
			case CallbackState::PAYMENT_RECEIVED:
				if ($invoice->isPending())
				{
					$invoice->status = 'completed';
					$invoice->payment_profile_id = $purchaseRequest->payment_profile_id;
					$invoice->save();
				}
				else if ($invoice->isCompleted() && $invoice->Ad)
				{
					$invoice->Ad->activate();
				}

                    $state->logType    = 'payment';
          		$state->logMessage = 'Payment received.';
				break;
			case CallbackState::PAYMENT_REINSTATED:

				break;
		}
	}
	public function reversePurchase(CallbackState $state)
	{
		$purchaseRequest = $state->getPurchaseRequest();
		$purchaser       = $state->getPurchaser();

		$invoice = \XF::em()->find('Siropu\AdsManager:Invoice', $purchaseRequest->extra_data['invoice_id']);
		$invoice->status = 'cancelled';
		$invoice->save();

		$state->logType    = 'cancel';
		$state->logMessage = 'Payment refunded/reversed.';
	}
	public function getPurchasablesByProfileId($profileId)
	{
          $purchasables = [];

		$invoices = \XF::finder('Siropu\AdsManager:Invoice')
               ->where('payment_profile_id', $profileId)
               ->fetch();

          $router = \XF::app()->router('public');

          foreach ($invoices as $invoice)
          {
               $purchasables['advertising_' . $invoice->invoice_id] = [
                    'title' => $this->getTitle() . ': ' . $invoice->invoice_id,
				'link'  => $router->buildLink('ads-manager/invoices/edit', $invoice)
               ];
          }

          return $purchasables;
	}
}
