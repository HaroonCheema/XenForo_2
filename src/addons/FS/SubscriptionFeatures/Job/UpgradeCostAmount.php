<?php

namespace FS\SubscriptionFeatures\Job;

use XF\Job\AbstractJob;

class UpgradeCostAmount extends AbstractJob
{
    protected $defaultData = [];

    public function run($maxRunTime)
    {
        $s = microtime(true);
        $app = \xf::app();

        $userUpgradeId = $this->data['userUpgradeId'];
        $newCostAmount = $this->data['cost_amount'];

        $purchaseExists = $app->finder('XF:PurchaseRequest')->where('provider_id', 'stripe')->where('purchasable_type_id', 'user_upgrade')->where('provider_metadata', '!=', 'NULL')->fetch();

        if (count($purchaseExists) && $userUpgradeId) {

            $providerId = "stripe";

            $finder = \XF::finder('XF:PaymentProfile');
            $paymentProfile = $finder
                ->where('provider_id', $providerId)
                ->fetchOne();

            /** @var \XF\Entity\PaymentProvider $provider */
            $provider = \XF::em()->find('XF:PaymentProvider', $providerId);

            $handler = $provider->handler;

            foreach ($purchaseExists as $value) {

                if ($value['extra_data']['user_upgrade_id'] == $userUpgradeId) {
                    // $subscriptionId = 'sub_1PQ5nvJcXHnOgcMNePpH0PB7';
                    $subscriptionId = $value['provider_metadata'];

                    $newAmount = intval(round($newCostAmount * 100));

                    $handler->updatePaymentSubscription($paymentProfile, $subscriptionId, $newAmount);
                }
            }
        }

        return $this->complete();
    }

    public function getStatusMessage()
    {
    }

    public function canCancel()
    {
        return true;
    }

    public function canTriggerByChoice()
    {
        return true;
    }
}
