<?php

namespace FS\SubscriptionFeatures\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Purchase extends XFCP_Purchase
{
    // public function actionIndex(ParameterBag $params)
    // {
    //     $userId = \XF::visitor()->user_id;

    //     if (!$userId) {
    //         return $this->noPermission();
    //     }

    //     $finder = \XF::finder('XF:UserUpgradeActive');
    //     $activeUpgradeGroup = $finder
    //         ->where('user_id', $userId)
    //         ->fetchOne();

    //         // user_upgrade_id

    //     if ($activeUpgradeGroup) {
    //         throw $this->exception($this->notFound(\XF::phrase('fs_repurchase_not_permission')));
    //     }

    //     return parent::actionIndex($params);
    // }

    public function actionIndex(ParameterBag $params)
    {

        $options = \XF::options();

        $user = \XF::visitor();

        $userId = $user['user_id'];

        $request = $this->app->request();

        $userUpgraseIdGet = $request->get('user_upgrade_id');

        // $alreadyExist = $this->finder('XF:UserUpgradeActive')->where('user_id', $userId)->where('user_upgrade_id', $userUpgraseIdGet)->fetchOne();

        // if ($alreadyExist) {
        //     return parent::actionIndex($params);
        // }

        if (!$userId) {
            return $this->error(\XF::phrase('requested_user_not_found'));
        }

        $ids = explode(',', $options->fs_subscrip_applicable_userGroups);

        if (!count($ids)) {
            return parent::actionIndex($params);
        }

        $activeUpgradeMember = $this->finder('XF:UserUpgradeActive')->where('user_id', $userId)->where('user_upgrade_id', $ids)->fetchOne();

        $upgrade = $this->assertUpgradeExists($userUpgraseIdGet);

        if ($activeUpgradeMember && $upgrade && in_array($userUpgraseIdGet, $ids)) {

            if ($activeUpgradeMember['user_upgrade_id'] == $upgrade['user_upgrade_id']) {
                return parent::actionIndex($params);
            }

            $preVActiveUpgrade = $this->assertUpgradeExists($activeUpgradeMember['user_upgrade_id']);

            $prevCostAmount = $preVActiveUpgrade['cost_amount'];
            $currentCostAmount = $upgrade['cost_amount'];

            $one_month_later_timestamp = strtotime('+1 month', \XF::$time);

            $endDate = isset($activeUpgradeMember['end_date']) ? $activeUpgradeMember['end_date'] : 0;

            if ($prevCostAmount >= $currentCostAmount) {

                if ($this->isPost() && $this->filter('convert', 'str')) {

                    /** @var \XF\Service\User\Upgrade $upgradeService */
                    $upgradeService = $this->service('XF:User\Upgrade', $upgrade, $user);
                    $upgradeService->setEndDate($endDate);
                    $upgradeService->ignoreUnpurchasable(true);
                    $upgradeService->upgrade();

                    /** @var \XF\Service\User\Downgrade $downgradeService */
                    $downgradeService = $this->service('XF:User\Downgrade', $activeUpgradeMember->Upgrade, $activeUpgradeMember->User);
                    $downgradeService->setSendAlert(false);
                    $downgradeService->downgrade();

                    return $this->redirect($this->buildLink('account/upgrades'));
                } else {
                    $viewParams = [
                        'activeUpgrade' => $activeUpgradeMember,
                        'upgrade' => $upgrade
                    ];
                    return $this->view('XF:Purchase\Index', 'fs_user_upgrade_active_convert', $viewParams);
                }

                return $this->redirect($this->buildLink('account/upgrades'));
            } else {

                $purchasable = $this->assertPurchasableExists($params->purchasable_type_id);

                if (!$purchasable->isActive()) {
                    throw $this->exception($this->error(\XF::phrase('items_of_this_type_cannot_be_purchased_at_moment')));
                }

                /** @var \XF\Purchasable\AbstractPurchasable $purchasableHandler */
                $purchasableHandler = $purchasable->handler;

                $purchase = $purchasableHandler->getPurchaseFromRequest($this->request, \XF::visitor(), $error);
                if (!$purchase) {
                    throw $this->exception($this->error($error));
                }

                $diffAmmount = $currentCostAmount - $prevCostAmount;

                $purchase['cost'] = $diffAmmount;

                $purchaseRequest = $this->repository('XF:Purchase')->insertPurchaseRequest($purchase);

                $providerHandler = $purchase->paymentProfile->getPaymentHandler();
                return $providerHandler->initiatePayment($this, $purchaseRequest, $purchase);
            }
        }

        return parent::actionIndex($params);
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \XF\Entity\UserUpgrade
     */
    protected function assertUpgradeExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('XF:UserUpgrade', $id, $with, $phraseKey);
    }
}
