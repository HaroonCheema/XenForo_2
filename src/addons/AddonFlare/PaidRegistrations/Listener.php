<?php

namespace AddonFlare\PaidRegistrations;

use XF\Mvc\Entity\Entity;
use AddonFlare\PaidRegistrations\IDs;

class Listener
{
    // used to track original user purchasing the gift
    public static $giftPurchaser = null;
    public static $isUpgradeExtend = false;

    public static function userUpgradeEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
    {
        $structure->relations['PaidRegistrationsAccountType'] = [
            'entity' => 'AddonFlare\PaidRegistrations:AccountType',
            'type' => Entity::TO_ONE,
            'conditions' => [['user_upgrade_id', '=', '$user_upgrade_id']],
        ];
    }

    public static function adminOptionControllerPostDispatch(\XF\Mvc\Controller $controller, $action, \XF\Mvc\ParameterBag $params, \XF\Mvc\Reply\AbstractReply &$reply)
    {
        if ($params['group_id'] == 'af_paidregistrations')
        {
            $reply->setSectionContext('af_paidregistrations_opt');
        }
    }

    public static function appPubRenderPage(\XF\Pub\App $app, array &$params, \XF\Mvc\Reply\AbstractReply $reply, \XF\Mvc\Renderer\AbstractRenderer $renderer)
    {
        if ($params['controller'] == 'XF:Account' && strtolower($params['action']) == 'upgrades' && $params['template'] == 'af_paidregistrations_accounttype_member')
        {
            if (!\XF::options()->af_paidregistrations_member_sideNav)
            {
                $params['sideNav'] = '';
            }
            if (!\XF::options()->af_paidregistrations_member_sidebar)
            {
                $params['sidebar'] = '';
            }
        }
    }

    public static function classMethodExists($class, $method)
    {
        static $classMethods = [];

        if (!isset($classMethods[$class][$method]))
        {
            $classMethods[$class][$method] = method_exists($class, $method);
        }

        return $classMethods[$class][$method];
    }

    public static function adminBrandingFreeText()
    {
        $text = 'The Full Version & Branding-Free option are available for purchase at <a target="_blank" href="https://www.addonflare.com/">AddonFlare.com</a>';
        return \XF::app()->templater()->formRow(
            IDs::hashes() ? '' : $text, []
        );
    }

    const ID = 'AddonFlare/PaidRegistrations';
    const TITLE = 'Paid Registrations';
    const ID_NUM = '89fcd07f20b6785b92134bd6c1d0fa42';
    public static $IDS1 = [

    ];
}