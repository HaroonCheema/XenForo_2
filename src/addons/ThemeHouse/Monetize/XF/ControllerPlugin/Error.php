<?php

namespace ThemeHouse\Monetize\XF\ControllerPlugin;

use ThemeHouse\Monetize\Repository\UpgradePage;
use ThemeHouse\Monetize\XF\PermissionSet;
use XF;
use XF\Entity\Purchasable;
use XF\Mvc\Reply\AbstractReply;
use XF\Mvc\Reply\View;
use XF\Pub\App;
use XF\Repository\Payment;

/**
 * Class Error
 * @package ThemeHouse\Monetize\XF\ControllerPlugin
 */
class Error extends XFCP_Error
{
    /**
     * @param $message
     * @return AbstractReply|XF\Mvc\Reply\Error|View
     */
    public function actionNoPermission($message)
    {
        $visitor = XF::visitor();

        if (!$visitor->user_id && !XF::options()->thmonetize_suggestUpgradeOnNoPermissionErrorGuests) {
            return parent::actionNoPermission($message);
        }

        if (!($this->app instanceof App)) {
            return parent::actionNoPermission($message);
        }

        $suggestUpgrade = XF::options()->thmonetize_suggestUpgradeOnNoPermissionError;

        if (!$suggestUpgrade) {
            return parent::actionNoPermission($message);
        }

        $routes = explode("\n", XF::options()->thmonetize_suggestUpgradeOnNoPermissionErrorRoutes);
        if (!empty($routes)) {
            $currentRoute = trim(\XF::app()->request()->getRoutePath(), '/');
            if (!$currentRoute) {
                $currentRoute = '/';
            }

            $regex = [];
            foreach ($routes as $route) {
                $pattern = trim(str_replace('/*', '((/.*)?)', $route), '/');
                if (!$pattern) {
                    $pattern = '/';
                }
                $regex[] = '(' . $pattern . ')';
            }
            $regex = '#^' . implode('|', $regex) . '$#';

            if (!preg_match($regex, $currentRoute)) {
                return parent::actionNoPermission($message);
            }
        }

        /** @var PermissionSet $permissionSet */
        $permissionSet = $visitor->PermissionSet;

        $lastFailedGlobalPermissionCheck = $permissionSet->getThMonetizeLastFailedGlobalPermissionCheck();
        if ($lastFailedGlobalPermissionCheck && XF::options()->thmonetize_excludeSuggestUpgradeGlobal) {
            $permissionId = implode('-', $lastFailedGlobalPermissionCheck);
            if (in_array($permissionId, XF::options()->thmonetize_excludeSuggestUpgradeGlobal)) {
                return parent::actionNoPermission($message);
            }
        }

        $lastFailedContentPermissionCheck = $permissionSet->getThMonetizeLastFailedContentPermissionCheck();
        if ($lastFailedContentPermissionCheck && XF::options()->thmonetize_excludeSuggestUpgradeContent) {
            $contentType = $lastFailedContentPermissionCheck[0];
            if (in_array($contentType, XF::options()->thmonetize_excludeSuggestUpgradeContent)) {
                return parent::actionNoPermission($message);
            }
        }

        /** @var Purchasable $purchasable */
        $purchasable = $this->em()->find('XF:Purchasable', 'user_upgrade', 'AddOn');
        if (!$purchasable->isActive()) {
            return parent::actionNoPermission($message);
        }

        if (!$message) {
            $message = XF::phrase('thmonetize_an_account_upgrade_is_required_to_continue', [
                'link' => XF::app()->router('public')->buildLink('account/upgrades'),
            ]);
        }

        $viewParams = [
            'error' => $message,
        ];

        /** @var UpgradePage $upgradePageRepo */
        $upgradePageRepo = $this->repository('ThemeHouse\Monetize:UpgradePage');
        list($upgradePage, $upgrades) =
            $upgradePageRepo->suggestUserUpgradePageForUser('error_message');

        if ($upgradePage) {
            /** @var Payment $paymentRepo */
            $paymentRepo = $this->repository('XF:Payment');
            $profiles = $paymentRepo->getPaymentProfileOptionsData();

            $viewParams['upgradePage'] = $upgradePage;
            $viewParams['upgrades'] = $upgrades;
            $viewParams['profiles'] = $profiles;
        }

        $view = $this->view('ThemeHouse\Monetize:Error\UpgradeRequired', 'thmonetize_upgrade_required', $viewParams);
        $view->setResponseCode(403);

        return $view;
    }
}
