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
        $visitor = \XF::visitor();
        $options = \XF::options();

        $userGroupId = intval($options->fs_cancel_multiple_subscriptions_userGroup);

        if ($providerId == "stripe" && $purchasableTypeId == "user_upgrade" && $visitor['user_id'] && $userGroupId) {
            $minutes = intval($options->fs_cancel_multiple_subscriptions_mintues);

            $finder = \XF::finder('FS\CancelMultipleSubscriptions:SubscriptionUserGroups')->where('user_id', $visitor['user_id'])->where('user_group_id', $userGroupId)->where('end_at', '>', time())->fetchOne();

            if (!$finder) {
                $tempGroup = $this->em()->create('FS\CancelMultipleSubscriptions:SubscriptionUserGroups');

                $tempGroup->user_id = $visitor['user_id'];
                $tempGroup->user_group_id = $userGroupId;
                $tempGroup->end_at = time() + ($minutes * 60);
                $tempGroup->save();
            }


            if (!in_array($userGroupId, $visitor['secondary_group_ids'])) {
                $secondaryGroupIds = $visitor['secondary_group_ids'];

                array_push($secondaryGroupIds, $userGroupId);

                $visitor->fastUpdate('secondary_group_ids', $secondaryGroupIds);
            }
        }

        return $parent;
    }
}
