<?php

namespace NF\GiftUpgrades\NF\Calendar\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

/**
 * Extends \NF\Calendar\Pub\Controller\Event
 */
class Event extends XFCP_Event
{
    /**
     * @param ParameterBag $params
     * @return AbstractReply
     * @throws \XF\Mvc\Reply\Exception
     * @throws \Exception
     */
    public function actionGift(ParameterBag $params): AbstractReply
    {
        $content = $this->assertViewableEvent($params->event_id);

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
        $content = $this->assertViewableEvent($params->event_id);

        /** @var \NF\GiftUpgrades\ControllerPlugin\Gift $plugin */
        $plugin = $this->plugin('NF\GiftUpgrades:Gift');
        return $plugin->actionListGifts($content);
    }
}