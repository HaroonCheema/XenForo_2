<?php

namespace NF\GiftUpgrades\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

/**
 * Extends \XF\Pub\Controller\ProfilePost
 */
class ProfilePost extends XFCP_ProfilePost
{
    /**
     * @param ParameterBag $params
     * @return AbstractReply
     * @throws \XF\Mvc\Reply\Exception
     * @throws \Exception
     */
    public function actionGift(ParameterBag $params): AbstractReply
    {
        $content = $this->assertViewableProfilePost($params->get('profile_post_id'));

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
        $content = $this->assertViewableProfilePost($params->get('profile_post_id'));

        /** @var \NF\GiftUpgrades\ControllerPlugin\Gift $plugin */
        $plugin = $this->plugin('NF\GiftUpgrades:Gift');
        return $plugin->actionListGifts($content);
    }

    /**
     * @param ParameterBag $params
     * @return AbstractReply
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionCommentsGift(ParameterBag $params)
    {
        $comment = $this->assertViewableComment($params->get('profile_post_comment_id'));
        $this->assertViewableProfilePost($comment->profile_post_id);

        /** @var \NF\GiftUpgrades\ControllerPlugin\Gift $plugin */
        $plugin = $this->plugin('NF\GiftUpgrades:Gift');
        return $plugin->actionGift($comment);
    }

    /**
     * @param ParameterBag $params
     * @return AbstractReply
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionCommentsGifts(ParameterBag $params)
    {
        $comment = $this->assertViewableComment($params->get('profile_post_comment_id'));
        $this->assertViewableProfilePost($comment->profile_post_id);

        /** @var \NF\GiftUpgrades\ControllerPlugin\Gift $plugin */
        $plugin = $this->plugin('NF\GiftUpgrades:Gift');
        return $plugin->actionListGifts($comment);
    }
}