<?php

namespace ThemeHouse\ThreadCredits\XF\Pub\Controller;

use ThemeHouse\ThreadCredits\Entity\ThreadPayment;
use ThemeHouse\ThreadCredits\Entity\UserCreditPackage;
use ThemeHouse\ThreadCredits\Repository\CreditPackage;
use ThemeHouse\ThreadCredits\XF\Entity\User;
use XF\Mvc\ParameterBag;
use XF\Repository\UserUpgrade;

class Thread extends XFCP_Thread
{
    public function actionThtcPay(ParameterBag $params)
    {
        $thread = $this->assertViewableThread($params['thread_id']);
        $page = $this->filterPage($params['page']);

        if (!$this->thtcRequiresCredits($thread, $page)) {
            return $this->redirect($this->buildLink('threads', $thread));
        }

        /** @var User $visitor */
        $visitor = \XF::visitor();
        if ($this->isPost()) {
            if (!$visitor->thtc_credits_cache) {
                return $this->noPermission();
            }

            /** @var CreditPackage $creditRepo */
            $creditRepo = $this->repository('ThemeHouse\ThreadCredits:CreditPackage');
            $userCreditPackageFinder = $creditRepo->findUserCreditPackagesForUser(\XF::visitor())
                ->where('remaining_credits', '>', 0);

            $userCreditPackageFinder
                ->activeOnly()
                ->orderByUseFirst();

            /** @var UserCreditPackage $userCreditPackage */
            $userCreditPackage = $userCreditPackageFinder->fetchOne();
            if (!$userCreditPackage) {
                return $this->noPermission();
            }

            $threadPayment = $this->em()->create('ThemeHouse\ThreadCredits:ThreadPayment');
            $threadPayment->bulkSet([
                'thread_id' => $thread->thread_id,
                'user_id' => \XF::visitor()->user_id,
                'user_credit_package_id' => $userCreditPackage->user_credit_package_id,
                'page' => $page
            ]);
            $threadPayment->save();

            return $this->redirect($this->buildLink('threads', $thread, ['page' => $page]));
        } else {
            if ($visitor->thtc_credits_cache) {
                $viewParams = [
                    'thread' => $thread,
                    'page' => $page
                ];

                return $this->view('ThemeHouse\ThreadCredits:Thread\Pay', 'thtc_thread_pay', $viewParams);
            } else {
                /** @var CreditPackage $repo */
                $creditPackageRepo = $this->repository('ThemeHouse\ThreadCredits:CreditPackage');

                /** @var UserUpgrade $subscriptionRepo */
                $subscriptionRepo = $this->repository('XF:UserUpgrade');
                $userUpgrades = $subscriptionRepo->findUserUpgradesForList()
                    ->where('can_purchase', true)
                    ->fetch();

                $creditPackages = $creditPackageRepo->findCreditPackagesForList()
                    ->purchasableOnly()
                    ->fetch();

                $viewParams = [
                    'thread' => $thread,
                    'creditPackages' => $creditPackages,
                    'subscriptions' => $userUpgrades
                ];

                return $this->view('ThemeHouse\ThreadCredits:Thread\Paywall', 'thtc_thread_paywall', $viewParams);
            }
        }
    }

    protected function thtcRequiresCredits(\XF\Entity\Thread $thread, $page): bool
    {
        if (!in_array($thread->node_id, \XF::options()->thtc_nodeIds)) {
            return false;
        }

        if ($thread->sticky) {
            return false;
        }

        if ($thread->getUserPostCount()) {
            return false;
        }

        if (\XF::visitor()->hasNodePermission($thread->node_id, 'thtc_bypass_credits')) {
            return false;
        }

        $timeout = \XF::options()->thtc_payOnce ? 0 : \XF::$time - 300;
        $payment = $this->findThtcThreadPayment($thread, $page, $timeout);
        if ($payment) {
            return false;
        }

        return true;
    }

    public function actionIndex(ParameterBag $params)
    {
        $thread = $this->assertViewableThread($params['thread_id']);
        $page = \XF::options()->thtc_payOnce ? null : $this->filterPage($params['page']);

        if ($this->thtcRequiresCredits($thread, $page)) {
            return $this->redirect($this->buildLink('threads/thtc-pay', $thread, [
                'page' => $page
            ]));
        }

        return parent::actionIndex($params);
    }

    protected function findThtcThreadPayment(\XF\Entity\Thread $thread, ?int $page, int $timeout): ?ThreadPayment
    {
        $finder = $this->finder('ThemeHouse\ThreadCredits:ThreadPayment')
            ->where('user_id', \XF::visitor()->user_id)
            ->where('thread_id', $thread->thread_id)
            ->where('purchased_at', '>=', $timeout);

        if ($page) {
            $finder->where('page', $page);
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $finder->fetchOne();
    }
}
