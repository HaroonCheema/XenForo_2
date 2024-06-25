<?php

namespace NF\GiftUpgrades\XenAddons\AMS\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

/**
 * Extends \XenAddons\AMS\Pub\Controller\ArticleItem
 */
class ArticleItem extends XFCP_ArticleItem
{
    /**
     * @param ParameterBag $params
     * @return AbstractReply
     * @throws \XF\Mvc\Reply\Exception
     * @throws \Exception
     */
    public function actionGift(ParameterBag $params): AbstractReply
    {
        $content = $this->assertViewableArticle($params->article_id);

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
        $content = $this->assertViewableArticle($params->article_id);

        /** @var \NF\GiftUpgrades\ControllerPlugin\Gift $plugin */
        $plugin = $this->plugin('NF\GiftUpgrades:Gift');
        return $plugin->actionListGifts($content);
    }
}