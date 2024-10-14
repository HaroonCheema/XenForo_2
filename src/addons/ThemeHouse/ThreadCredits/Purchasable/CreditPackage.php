<?php

namespace ThemeHouse\ThreadCredits\Purchasable;

use ThemeHouse\ThreadCredits\Entity\CreditPackage as CreditPackageEntity;
use ThemeHouse\ThreadCredits\Entity\UserCreditPackage;
use XF\Entity\PaymentProfile;
use XF\Payment\CallbackState;
use XF\Purchasable\AbstractPurchasable;
use XF\Purchasable\Purchase;

class CreditPackage extends AbstractPurchasable
{
    public function getTitle()
    {
        return \XF::phrase('thtc_credit_packages');
    }

    public function getPurchaseFromRequest(\XF\Http\Request $request, \XF\Entity\User $purchaser, &$error = null)
    {
        if (!$purchaser->user_id)
        {
            $error = \XF::phrase('login_required');
            return false;
        }

        $profileId = $request->filter('payment_profile_id', 'uint');
        /** @var PaymentProfile $paymentProfile */
        $paymentProfile = \XF::em()->find('XF:PaymentProfile', $profileId);
        if (!$paymentProfile || !$paymentProfile->active)
        {
            $error = \XF::phrase('please_choose_valid_payment_profile_to_continue_with_your_purchase');
            return false;
        }

        $creditPackageId = $request->filter('credit_package_id', 'uint');
        /** @var CreditPackageEntity $creditPackage */
        $creditPackage = \XF::em()->find('ThemeHouse\ThreadCredits:CreditPackage', $creditPackageId);
        if (!$creditPackage || !$creditPackage->canPurchase())
        {
            $error = \XF::phrase('this_item_cannot_be_purchased_at_moment');
            return false;
        }

        if (!in_array($profileId, $creditPackage->payment_profile_ids))
        {
            $error = \XF::phrase('selected_payment_profile_is_not_valid_for_this_purchase');
            return false;
        }

        return $this->getPurchaseObject($paymentProfile, $creditPackage, $purchaser);
    }

    public function getPurchasableFromExtraData(array $extraData)
    {
        $output = [
            'link' => '',
            'title' => '',
            'purchasable' => null
        ];
        /** @var CreditPackageEntity $creditPackage */
        $creditPackage = \XF::em()->find('ThemeHouse\ThreadCredits:CreditPackage', $extraData['credit_package_id']);
        if ($creditPackage)
        {
            $output['link'] = \XF::app()->router('admin')->buildLink('thtc-credit-package/edit', $creditPackage);
            $output['title'] = $creditPackage->title;
            $output['purchasable'] = $creditPackage;
        }
        return $output;
    }

    public function getPurchaseFromExtraData(array $extraData, \XF\Entity\PaymentProfile $paymentProfile, \XF\Entity\User $purchaser, &$error = null)
    {
        $userUpgrade = $this->getPurchasableFromExtraData($extraData);
        if (!$userUpgrade['purchasable'] || !$userUpgrade['purchasable']->canPurchase())
        {
            $error = \XF::phrase('this_item_cannot_be_purchased_at_moment');
            return false;
        }

        if (!in_array($paymentProfile->payment_profile_id, $userUpgrade['purchasable']->payment_profile_ids))
        {
            $error = \XF::phrase('selected_payment_profile_is_not_valid_for_this_purchase');
            return false;
        }

        return $this->getPurchaseObject($paymentProfile, $userUpgrade['purchasable'], $purchaser);
    }

    public function getPurchaseObject(\XF\Entity\PaymentProfile $paymentProfile, $purchasable, \XF\Entity\User $purchaser)
    {
        $purchase = new Purchase();

        /** @var CreditPackageEntity $purchasable */
        $purchase->title = \XF::phrase('thtc_credit_package') . ': ' . $purchasable->title . ' (' . $purchaser->username . ')';
        $purchase->description = $purchasable->description;
        $purchase->cost = $purchasable->cost_amount;
        $purchase->currency = $purchasable->cost_currency;
        $purchase->recurring = false;
        $purchase->lengthAmount = $purchasable->length_amount;
        $purchase->lengthUnit = $purchasable->length_unit;
        $purchase->purchaser = $purchaser;
        $purchase->paymentProfile = $paymentProfile;
        $purchase->purchasableTypeId = $this->purchasableTypeId;
        $purchase->purchasableId = $purchasable->credit_package_id;
        $purchase->purchasableTitle = $purchasable->title;
        $purchase->extraData = [
            'credit_package_id' => $purchasable->credit_package_id
        ];

        $router = \XF::app()->router('public');

        // TODO: Change
        $purchase->returnUrl = $router->buildLink('canonical:account/thtc-credit-package-purchase');
        $purchase->cancelUrl = $router->buildLink('canonical:account/thtc-credit-packages');

        return $purchase;
    }

    public function completePurchase(CallbackState $state)
    {
        $purchaseRequest = $state->getPurchaseRequest();
        $creditPackageId = $purchaseRequest->extra_data['credit_package_id'];
        $userCreditPackageId = $purchaseRequest->extra_data['user_credit_package_id'] ?? null;

        $paymentResult = $state->paymentResult;
        $purchaser = $state->getPurchaser();

        /** @var CreditPackageEntity $creditPackage */
        $creditPackage = \XF::em()->find('ThemeHouse\ThreadCredits:CreditPackage', $creditPackageId);
        /** @var \ThemeHouse\ThreadCredits\Service\CreditPackage\Purchase $purchaseService */
        $purchaseService = \XF::app()->service('ThemeHouse\ThreadCredits:CreditPackage\Purchase', $creditPackage, $purchaser);

        if ($state->extraData && is_array($state->extraData))
        {
            $purchaseService->setExtraData($state->extraData);
        }

        $userCreditPackage = null;
        switch ($paymentResult)
        {
            case CallbackState::PAYMENT_RECEIVED:
                $purchaseService->setPurchaseRequestKey($state->requestKey);
                $userCreditPackage = $purchaseService->purchase();

                $state->logType = 'payment';
                $state->logMessage = 'Payment received, credits granted.';
                break;

            case CallbackState::PAYMENT_REINSTATED:
                // Shouldn't happen, but keep track record
                $state->logType = 'info';
                $state->logMessage = 'OK, no action.';
                break;
        }

        if ($userCreditPackage && $purchaseRequest)
        {
            $extraData = $purchaseRequest->extra_data;
            $extraData['user_credit_package_id'] = $userCreditPackage->user_credit_package_id;
            $purchaseRequest->extra_data = $extraData;
            $purchaseRequest->save();
        }
    }

    public function reversePurchase(CallbackState $state)
    {
        $purchaseRequest = $state->getPurchaseRequest();
        $creditPackageId = $purchaseRequest->extra_data['credit_package_id'];
        $userCreditPackageId = $purchaseRequest->extra_data['user_credit_package_id'] ?? null;

        $purchaser = $state->getPurchaser();
        /** @var UserCreditPackage $userCreditPackage */
        $userCreditPackage = \XF::em()->find('ThemeHouse\ThreadCredits:UserCreditPackage', $userCreditPackageId);
        $userCreditPackage->expire(true);

        $state->logType = 'cancel';
        $state->logMessage = 'Payment refunded/reversed, credits revoked.';
    }

    public function getPurchasablesByProfileId($profileId)
    {
        $finder = \XF::finder('ThemeHouse\ThreadCredits:CreditPackage');

        $quotedProfileId = $finder->quote($profileId);
        $columnName = $finder->columnSqlName('payment_profile_ids');

        $router = \XF::app()->router('admin');
        $creditPackages = $finder->whereSql("FIND_IN_SET($quotedProfileId, $columnName)")->fetch();
        return $creditPackages->pluck(function(CreditPackageEntity $creditPackage, $key) use ($router)
        {
            return ['thtc_credit_package_' . $key, [
                'title' => $this->getTitle() . ': ' . $creditPackage->title,
                'link' => $router->buildLink('thtc-credit-package/edit', $creditPackage)
            ]];
        }, false);
    }
}