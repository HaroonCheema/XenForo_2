<?php

namespace NF\GiftUpgrades\Gift;

use XF\Mvc\Entity\Entity;

/**
 * Class NFEvent
 *
 * @package NF\GiftUpgrades\Gift
 */
class NFEvent extends AbstractHandler
{
    public function getEntityWith(): array
    {
        $visitor = \XF::visitor();

        return [
            'Calendar',
            'Calendar.Permissions|'.$visitor->permission_combination_id
        ];
    }

    public function getContentUser(Entity $entity): \XF\Entity\User
    {
        /** @var \NF\GiftUpgrades\NF\Calendar\Entity\Event $entity */
        return $entity->User;
    }

    public function getContentUrl(Entity $entity): string
    {
        return \XF::app()->router('public')->buildLink('events', $entity);
    }

    public function getBreadCrumbs(Entity $entity): array
    {
        /** @var \NF\Calendar\Entity\Event $entity */
        return $entity->Calendar->getBreadcrumbs(true);
    }

    public function getGiftRoute(): string
    {
        return 'events/gift';
    }

    public function getGiftsRoute(): string
    {
        return 'events/gifts';
    }
}