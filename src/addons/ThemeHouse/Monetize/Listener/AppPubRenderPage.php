<?php

namespace ThemeHouse\Monetize\Listener;

use ThemeHouse\Monetize\Repository\UpgradePage;
use XF\Mvc\Renderer\AbstractRenderer;
use XF\Mvc\Reply\AbstractReply;
use XF\Mvc\Reply\Error;
use XF\Pub\App;
use XF\Repository\Payment;

/**
 * Class AppPubRenderPage
 * @package ThemeHouse\Monetize\Listener
 */
class AppPubRenderPage
{
    /**
     * @param App $app
     * @param array $params
     * @param AbstractReply $reply
     * @param AbstractRenderer $renderer
     */
    public static function appPubRenderPage(App $app, array &$params, AbstractReply $reply, AbstractRenderer $renderer)
    {
        if ($params['controller'] === 'XF:Account' && $params['action'] === 'Upgrades') {
            return;
        }

        if (!($reply instanceof Error)) {
            return;
        }

        /** @var UpgradePage $upgradePageRepo */
        $upgradePageRepo = $app->repository('ThemeHouse\Monetize:UpgradePage');
        list($upgradePage, $upgrades) = $upgradePageRepo->suggestUserUpgradePageForUser('overlay', null, null, $params);

        if ($upgradePage) {
            $params['thmonetize_upgradePage'] = $upgradePage;
            $params['thmonetize_upgrades'] = $upgrades;

            /** @var Payment $paymentRepo */
            $paymentRepo = $app->repository('XF:Payment');
            $params['thmonetize_profiles'] = $paymentRepo->getPaymentProfileOptionsData();
        }
    }
}
