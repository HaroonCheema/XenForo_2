<?php

namespace AddonFlare\PaidRegistrations\XF\Purchasable;

use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;
use XF\Entity\PurchaseRequest;

use AddonFlare\PaidRegistrations\Listener;

class UserUpgrade extends XFCP_UserUpgrade
{
    use \AddonFlare\PaidRegistrations\Payment\PaidRegistrationsTrait;

    const FAKE_GUEST_USER_ID = 99999999;

    protected $isFakedGuestUserId = false;

    public function getPurchaseFromRequest(\XF\Http\Request $request, \XF\Entity\User $purchaser, &$error = null)
    {
        // XF 2.1.4 implements a check for a valid user_id, fake a valid userID before calling the parent function, then set it back to 0
        if (!$purchaser->user_id && \XF::options()->af_paidregistrations_guest)
        {
            $purchaser->setReadOnly(false);
            // need forceSet since user_id is an auto_increment column
            $purchaser->set('user_id', self::FAKE_GUEST_USER_ID, ['forceSet' => true]);
            $purchaser->setReadOnly(true);

            $this->isFakedGuestUserId = true;
        }

        if (!$purchase = parent::getPurchaseFromRequest($request, $purchaser, $error))
        {
            return $purchase;
        }

        // if we had to fake the userID for the parent method, set it back to 0
        if ($this->isFakedGuestUserId)
        {
            $purchaser->setReadOnly(false);
            $purchaser->set('user_id', 0, ['forceSet' => true]);
            $purchaser->setReadOnly(true);
        }

        if (!$purchaser->user_id && $request->filter('registration', 'bool'))
        {
            $accountTypeClass = \XF::extendClass('AddonFlare\PaidRegistrations\Entity\AccountType');
            if (!in_array($purchase->paymentProfile->provider_id, $accountTypeClass::getSupportedPaymentProviderIds()))
            {
                $error = \XF::phrase('selected_payment_profile_is_not_valid_for_this_purchase');
                return false;
            }

            $email = $request->filter('email', 'str');

            $userRepo = \XF::repository('XF:User');

            // only used for validation purposes
            $validationUser = $userRepo->getGuestUser();
            if (!$validationUser->verifyVerifyEmail($email, $errors))
            {
                throw new \XF\PrintableException($errors);
            }

            // direct modification causes error bc it's using magic methods
            $extraData = $purchase->extraData;
            $extraData['email'] = $email;
            $purchase->extraData = $extraData; // this gets returned so no need to save now
        }

        return $purchase;
    }

    public function getPurchaseFromExtraData(array $extraData, \XF\Entity\PaymentProfile $paymentProfile, \XF\Entity\User $purchaser, &$error = null)
    {

        if ($purchase = parent::getPurchaseFromExtraData($extraData, $paymentProfile, $purchaser, $error))
        {

            // if is a guest purchase, redirect back to complete registration
            $request = \XF::app()->request();
            if (!$purchaser->user_id && ($requestKey = $request->filter('request_key', 'str')))
            {
                $purchase->returnUrl = $this->generateReturnUrl($requestKey);
            }
        }

        return $purchase;
    }

    public function getPurchaseObject(\XF\Entity\PaymentProfile $paymentProfile, $purchasable, \XF\Entity\User $purchaser)
    {
        $purchase = parent::getPurchaseObject($paymentProfile, $purchasable, $purchaser);

        $router = \XF::app()->router('public');

        $giftPurchaser = null;

        if (!$purchaser->user_id || $this->isFakedGuestUserId)
        {
            // is guest purchase, remove username from title
            $purchase->title = \XF::phrase('account_upgrade') . ': ' . $purchasable->title;

            // can't pass the prk to the returnUrl here since the purchaseRequest hasn't been created yet
            $purchase->returnUrl = $router->buildLink('canonical:register');
            $purchase->cancelUrl = $router->buildLink('canonical:register');
        }
        else if ($giftPurchaser = Listener::$giftPurchaser)
        {
            $extraData = $purchase->extraData;
            $extraData['gift_from_userId'] = $giftPurchaser->user_id;
            $purchase->extraData = $extraData;
        }

        return $purchase;
    }
}