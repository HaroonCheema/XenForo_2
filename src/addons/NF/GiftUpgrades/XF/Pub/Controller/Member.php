<?php

namespace NF\GiftUpgrades\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

/**
 * Extends \XF\Pub\Controller\Member
 */
class Member extends XFCP_Member
{
    /**
     * @param ParameterBag $params
     * @return AbstractReply
     * @throws \XF\Mvc\Reply\Exception
     * @throws \Exception
     */
    public function actionGift(ParameterBag $params): AbstractReply
    {
        $content = $this->assertViewableUser($params->get('user_id'));

        /** @var \NF\GiftUpgrades\ControllerPlugin\Gift $plugin */
        $plugin = $this->plugin('NF\GiftUpgrades:Gift');
        return $plugin->actionGift($content);
    }

    /**
     * @param ParameterBag $params
     * @return AbstractReply
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionGifts(ParameterBag $params): AbstractReply
    {
        $content = $this->assertViewableUser($params->get('user_id'));
        // todo: moderator access
        if ($content->user_id !== \XF::visitor()->user_id)
        {
            return $this->notFound();
        }

        /** @var \NF\GiftUpgrades\ControllerPlugin\Gift $plugin */
        $plugin = $this->plugin('NF\GiftUpgrades:Gift');
        return $plugin->actionListGifts($content);
    }
}