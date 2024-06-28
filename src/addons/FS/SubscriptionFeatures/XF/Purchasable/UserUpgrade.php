<?php

namespace FS\SubscriptionFeatures\XF\Purchasable;

use XF\Payment\CallbackState;

class UserUpgrade extends XFCP_UserUpgrade
{

    public function completePurchase(CallbackState $state)
    {
        $parent = parent::completePurchase($state);

        if ($state->legacy) {
            $purchaseRequest = null;
            $userUpgradeId = $state->userUpgrade->user_upgrade_id;
        } else {
            $purchaseRequest = $state->getPurchaseRequest();
            $userUpgradeId = $purchaseRequest->extra_data['user_upgrade_id'];
        }

        $purchaser = $state->getPurchaser();

        $userUpgrade = \XF::em()->find(
            'XF:UserUpgrade',
            $userUpgradeId,
            'Active|' . $purchaser->user_id
        );

        /** @var \XF\Service\User\Upgrade $upgradeService */
        $upgradeService = \XF::app()->service('XF:User\Upgrade', $userUpgrade, $purchaser);

        $options = \XF::options();

        $ids = explode(',', $options->fs_subscrip_applicable_userGroups);

        if ($ids) {

            if (in_array($userUpgradeId, $ids)) {

                $upgradeService->setPurchaseRequestKey($state->requestKey);
                $activeUser = $upgradeService->getUser();

                if ($purchaseRequest->purchase_request_id && $userUpgrade->user_upgrade_id) {
                    if ($purchaseRequest->provider_id == "stripe" && $purchaseRequest->purchasable_type_id == "user_upgrade" && $purchaseRequest->provider_metadata != "NULL" && $purchaseRequest->cost_amount != $userUpgrade->cost_amount) {

                        $providerId = $purchaseRequest->provider_id;

                        $finder = \XF::finder('XF:PaymentProfile');
                        $paymentProfile = $finder
                            ->where('provider_id', $providerId)
                            ->fetchOne();

                        /** @var \XF\Entity\PaymentProvider $provider */
                        $provider = \XF::em()->find('XF:PaymentProvider', $providerId);

                        $handler = $provider->handler;

                        $subscriptionId = $purchaseRequest['provider_metadata'];

                        $newAmount = intval(round($userUpgrade->cost_amount * 100));

                        $handler->updatePaymentSubscription($paymentProfile, $subscriptionId, $newAmount);
                    }
                }

                if ($purchaser->user_id == $activeUser->user_id) {

                    $newIds = array_diff($ids, array($userUpgradeId));

                    $activeUpgrades = \XF::finder('XF:UserUpgradeActive')->where('user_upgrade_id', $newIds)->where('user_id', $purchaser->user_id)
                        ->fetch();

                    if (count($activeUpgrades)) {
                        foreach ($activeUpgrades as $value) {

                            /** @var \XF\Service\User\Downgrade $downgradeService */
                            $downgradeService = \XF::service('XF:User\Downgrade', $value->Upgrade, $value->User);
                            $downgradeService->setSendAlert(false);
                            $downgradeService->downgrade();
                        }
                    }
                }
            }
        }

        return $parent;
    }
}
