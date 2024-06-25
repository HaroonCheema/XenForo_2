<?php

namespace NF\GiftUpgrades\Gift;

use XF\Mvc\Entity\Entity;

/**
 * Class User
 *
 * @package NF\GiftUpgrades\Gift
 */
class User extends AbstractHandler
{
	public function getEntityWith(): array
    {
		return [];
	}

    public function getContentUser(Entity $entity): \XF\Entity\User
    {
        /** @var \NF\GiftUpgrades\XF\Entity\User $entity */
        return $entity;
    }

    public function getContentUrl(Entity $entity): string
    {
        return \XF::app()->router('public')->buildLink('members', $entity);
    }

    public function getBreadCrumbs(Entity $entity): array
    {
        /** @var \XF\Entity\User $entity */

        /** @var \XF\Entity\ProfilePostComment $entity */
        $router = \XF::app()->router('public');

        return [
            [
                'href'  => $router->buildLink('members'),
                'value' => \XF::phrase('members')
            ],
            [
                'href'  => $router->buildLink('members', $entity),
                'value' => $entity->username
            ]
        ];
    }

    public function getGiftRoute(): string
    {
        return 'members/gift';
    }

    public function getGiftsRoute(): string
    {
        return 'members/gifts';
    }
}