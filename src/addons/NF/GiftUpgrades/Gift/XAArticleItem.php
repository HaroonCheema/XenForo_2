<?php

namespace NF\GiftUpgrades\Gift;

use XF\Mvc\Entity\Entity;

/**
 * Class XAArticleItem
 *
 * @package NF\GiftUpgrades\Gift
 */
class XAArticleItem extends AbstractHandler
{
    public function getEntityWith(): array
    {
        $visitor = \XF::visitor();

        return ['Category', 'Category.Permissions|' . $visitor->permission_combination_id];
    }

    public function getContentUser(Entity $entity): \XF\Entity\User
    {
        /** @var \NF\GiftUpgrades\XenAddons\AMS\Entity\ArticleItem $entity */
        return $entity->User;
    }

    public function getContentUrl(Entity $entity): string
    {
        return \XF::app()->router('public')->buildLink('ams', $entity);
    }

    public function getBreadCrumbs(Entity $entity): array
    {
        /** @var \XenAddons\AMS\Entity\ArticleItem $entity */
        return $entity->Category->getBreadcrumbs(true);
    }

    public function getGiftRoute(): string
    {
        return 'ams/gift';
    }

    public function getGiftsRoute(): string
    {
        return 'ams/gifts';
    }
}