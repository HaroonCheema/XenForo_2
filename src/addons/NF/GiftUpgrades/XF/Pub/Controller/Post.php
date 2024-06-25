<?php

namespace NF\GiftUpgrades\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

/**
 * Extends \XF\Pub\Controller\Post
 */
class Post extends XFCP_Post
{
    /**
     * @param ParameterBag $params
     * @return AbstractReply
     * @throws \XF\Mvc\Reply\Exception
     * @throws \Exception
     */
    public function actionGift(ParameterBag $params): AbstractReply
    {
        $content = $this->assertViewablePost($params->get('post_id'));

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
        $content = $this->assertViewablePost($params->get('post_id'));

        /** @var \NF\GiftUpgrades\ControllerPlugin\Gift $plugin */
        $plugin = $this->plugin('NF\GiftUpgrades:Gift');
        return $plugin->actionListGifts($content);
    }
}