<?php

namespace ThemeHouse\Monetize\XF\Pub\Controller;

use ThemeHouse\Monetize\XF\Repository\UserUpgrade;
use XF\Entity\Purchasable;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

/**
 * Class Account
 * @package ThemeHouse\Monetize\XF\Pub\Controller
 */
class Account extends XFCP_Account
{
    /**
     * @var ParameterBag
     */
    protected $parameterBag;

    /**
     * @param $action
     * @param ParameterBag $params
     */
    public function preDispatch($action, ParameterBag $params)
    {
        $this->parameterBag = $params;
        parent::preDispatch($action, $params);
    }

    /**
     * @return \XF\Mvc\Reply\Error|\XF\Mvc\Reply\Message|View
     */
    public function actionUpgrades()
    {
        $visitor = \XF::visitor();

        if ($visitor->user_id && !in_array($visitor->user_state, ['thmonetize_upgrade', 'email_confirm'])) {
            $reply = parent::actionUpgrades();
        } else {
            /** @var Purchasable $purchasable */
            $purchasable = $this->em()->find('XF:Purchasable', 'user_upgrade', 'AddOn');
            if (!$purchasable->isActive()) {
                return $this->message(\XF::phrase('no_account_upgrades_can_be_purchased_at_this_time'));
            }

            /** @var UserUpgrade $upgradeRepo */
            $upgradeRepo = $this->repository('XF:UserUpgrade');
            list($available, $purchased) = $upgradeRepo->getFilteredUserUpgradesForList();

            if (!$available && !$purchased) {
                return $this->message(\XF::phrase('no_account_upgrades_can_be_purchased_at_this_time'));
            }

            /** @var \XF\Repository\Payment $paymentRepo */
            $paymentRepo = $this->repository('XF:Payment');
            $profiles = $paymentRepo->getPaymentProfileOptionsData();

            $viewParams = [
                'available' => $available,
                'purchased' => $purchased,
                'profiles' => $profiles,
                'removeAccountWrapper' => true,
                'redirect' => $this->filter('_xfRedirect', 'str'),
            ];
            $view = $this->view('XF:Account\Upgrades', 'account_upgrades', $viewParams);
            $reply = $this->addAccountWrapperParams($view, 'upgrades');
        }

        $showAll = $this->filter('show_all', 'bool');

        if ($reply instanceof View) {
            $couponRepo = $this->repository('ThemeHouse\Monetize:Coupon');
            $coupons = $couponRepo->fetchCoupons()->filterViewable();
            $coupon = null;
            if ($couponCode = $this->session()->upgradeCoupon) {
                $coupon = $this->finder('ThemeHouse\Monetize:Coupon')->byCode($couponCode)->fetchOne();
            }

            if (!$showAll) {
                $upgradePageId = $this->filter('upgrade_page_id', 'int');
                $filter = $this->filter('filter', 'str', \XF::options()->thmonetize_defaultTimePeriodFilter);

                $upgradePageRepo = $this->getUpgradePageRepo();
                list($upgradePage, $upgrades) = $upgradePageRepo->suggestUserUpgradePageForUser(
                    $upgradePageId ? null : 'accounts_page',
                    $reply->getParam('available'),
                    $reply->getParam('purchased'),
                    [],
                    $upgradePageId ? [$upgradePageId] : null,
                    $filter
                );

                $profiles = $reply->getParam('profiles');

                if ($upgradePage) {
                    $viewParams = [
                        'upgradePage' => $upgradePage,
                        'upgrades' => $upgrades,
                        'profiles' => $profiles,
                        'filter' => $filter,
                        'showFilters' => $upgradePageRepo->enableTimePeriodFilters(),
                        'redirect' => $this->filter('_xfRedirect', 'str'),
                        'coupons' => $coupons,
                        'coupon' => $coupon,
                    ];

                    return $this->view('ThemeHouse\Monetize:UpgradePage\View', 'thmonetize_upgrade_page_view',
                        $viewParams);
                } elseif ($upgradePageId) {
                    return $this->notFound();
                }
            }

            /** @var \ThemeHouse\Monetize\XF\Repository\UserUpgrade $upgradeRepo */
            $upgradeRepo = $this->repository('XF:UserUpgrade');
            $reply->setParam(
                'available',
                $upgradeRepo->thMonetizeAddFeaturesToDescription($reply->getParam('available'))
            );
            $reply->setParam(
                'purchased',
                $upgradeRepo->thMonetizeAddFeaturesToDescription($reply->getParam('purchased'))
            );

            $reply->setParam('coupons', $coupons);
            $reply->setParam('coupon', $coupon);
        }

        return $reply;
    }

    public function actionUpgradeCoupon()
    {
        if ($this->filter('remove', 'bool')) {
            unset($this->session()->upgradeCoupon);

            return $this->redirect($this->getDynamicRedirect(), \XF::phrase('thmonetize_your_coupon_has_been_removed'));
        }

        $couponCode = $this->filter('coupon', 'str');

        if (!$couponCode) {
            return $this->error(\XF::phrase('thmonetize_please_enter_a_valid_coupon_code'));
        }

        $coupon = $this->finder('ThemeHouse\Monetize:Coupon')->byCode($couponCode)->fetchOne();

        if (!$coupon || !$coupon->canView()) {
            return $this->error(\XF::phrase('thmonetize_please_enter_a_valid_coupon_code'));
        }

        $this->session()->upgradeCoupon = $couponCode;

        return $this->redirect($this->getDynamicRedirect(), \XF::phrase('thmonetize_your_coupon_has_been_redeemed'));
    }

    public function actionUpgradePurchase()
    {
        unset($this->session()->upgradeCoupon);

        return parent::actionUpgradePurchase();
    }

    /**
     * @return \ThemeHouse\Monetize\Repository\UpgradePage
     */
    protected function getUpgradePageRepo()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->repository('ThemeHouse\Monetize:UpgradePage');
    }

    /**
     * @return View
     */
    public function actionUpgradeFree()
    {
        $view = $this->view('ThemeHouse\Monetize:Account\UpgradePurchase', 'thmonetize_account_upgrade_free');
        return $this->addAccountWrapperParams($view, 'upgrades');
    }

    /**
     * @param $action
     * @param ParameterBag $params
     */
    protected function preDispatchController($action, ParameterBag $params)
    {
        if (!\XF::options()->thmonetize_allowGuestsToViewUserUpgrades || $action !== 'Upgrades') {
            parent::preDispatchController($action, $params);
        }
    }
}
