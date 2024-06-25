<?php

namespace ThemeHouse\Monetize\XF\Purchasable;

use XF;
use XF\Entity\User;
use XF\Http\Request;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

/**
 * Class UserUpgrade
 * @package ThemeHouse\Monetize\XF\Purchasable
 */
class UserUpgrade extends XFCP_UserUpgrade
{
    /**
     * @param Request $request
     * @param User $purchaser
     * @param null $error
     * @return bool|Purchase
     */
    public function getPurchaseFromRequest(Request $request, User $purchaser, &$error = null)
    {
        $purchase = parent::getPurchaseFromRequest($request, $purchaser, $error);

        if ($purchase) {
            $userUpgradeId = $request->filter('user_upgrade_id', 'uint');
            /** @var \ThemeHouse\Monetize\XF\Entity\UserUpgrade $userUpgrade */
            $userUpgrade = XF::em()->find('XF:UserUpgrade', $userUpgradeId);

            if ($userUpgrade && $userUpgrade->thmonetize_custom_amount) {
                $costAmount = $request->filter('thmonetize_cost_amount', 'num', $userUpgrade->cost_amount);
                if ($costAmount < $userUpgrade->cost_amount) {
                    $error = XF::phrase('thmonetize_amount_must_be_greater_than_x', [
                        'cost' => XF::app()->data('XF:Currency')->languageFormat(
                            $userUpgrade->cost_amount,
                            $userUpgrade->cost_currency
                        ),
                    ]);
                    return false;
                }

                if ($costAmount) {
                    $purchase->cost = $costAmount;
                }
            }

            if($userUpgrade->thmonetize_redirect_url) {
                // needs to be stored in the purchase request to access later
                $purchase->extraData += [
                    'return_url' => $userUpgrade->thmonetize_redirect_url,
                ];
            }

            return $purchase;
        }

        return false;
    }

    public function getPurchaseObject(\XF\Entity\PaymentProfile $paymentProfile, $purchasable, \XF\Entity\User $purchaser)
    {
        $purchase = parent::getPurchaseObject($paymentProfile, $purchasable, $purchaser);

        $redirect = \XF::app()->request()->filter('_xfRedirect', 'str');
        if ($redirect && $redirect != '/') {
            // needs to be stored in the purchase request to access later
            $purchase->extraData += [
                'return_url' => $redirect,
            ];
        }

        if ($purchaseRequestId = \XF::app()->request()->filter(['request_key' => 'str'])) {
            // if we have a purchase request (the second time this method is called), retrieve the URL we set before
            $purchaseRequest = \XF::app()->em()->findOne('XF:PurchaseRequest', $purchaseRequestId);
            if ($purchaseRequest) {
                if (!empty($purchaseRequest->extra_data['return_url'])) {
                    $purchase->returnUrl = $purchaseRequest->extra_data['return_url'];
                }
            }
        }

        return $purchase;
    }

    /**
     * @param CallbackState $state
     * @return null
     */
    public function sendPaymentReceipt(CallbackState $state)
    {
        if (\XF::options()->thmonetize_sendUpgradeReceipt && $state->getPurchaseRequest() && $state->getPurchaseRequest()->cost_amount) {
            parent::sendPaymentReceipt($state);
        }
        return;
    }
}
