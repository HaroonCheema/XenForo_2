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

        $options = \XF::options();

        $ids = explode(',', $options->fs_subscrip_applicable_userGroups);

        if ($ids) {

            if (in_array($userUpgradeId, $ids)) {
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

        return $parent;
    }
}
