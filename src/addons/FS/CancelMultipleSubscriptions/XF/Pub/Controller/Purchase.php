<?php

namespace FS\CancelMultipleSubscriptions\XF\Pub\Controller;

class Purchase extends XFCP_Purchase
{
    public function actionProcess()
    {
        $parent = parent::actionProcess();

        $purchaseRequest = $this->em()->findOne('XF:PurchaseRequest', $this->filter(['request_key' => 'str']), 'User');

        $providerId = $purchaseRequest['provider_id'];
        $purchasableTypeId = $purchaseRequest['purchasable_type_id'];
        $user = \XF::visitor();
        $options = \XF::options();

        $userGroupId = intval($options->fs_cancel_multiple_subscriptions_userGroup);

        if ($providerId == "stripe" && $purchasableTypeId == "user_upgrade" && $user['user_id'] && $userGroupId) {
            $minutes = intval($options->fs_cancel_multiple_subscriptions_mintues);

            $tempGroup = $this->em()->create('FS\CancelMultipleSubscriptions:SubscriptionUserGroups');

            $tempGroup->user_id = $user['user_id'];
            $tempGroup->user_group_id = $userGroupId;
            $tempGroup->end_at = time() + ($minutes * 60);
            $tempGroup->save();
        }

        return $parent;
    }
}
