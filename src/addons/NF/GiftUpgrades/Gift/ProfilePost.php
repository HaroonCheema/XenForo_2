<?php

namespace NF\GiftUpgrades\Gift;

use XF\Mvc\Entity\Entity;

/**
 * Class ProfilePost
 *
 * @package NF\GiftUpgrades\Gift
 */
class ProfilePost extends AbstractHandler
{
	public function getEntityWith(): array
    {
		return ['ProfileUser', 'ProfileUser.Privacy'];
	}

    public function getContentUser(Entity $entity): \XF\Entity\User
    {
        /** @var \NF\GiftUpgrades\XF\Entity\ProfilePost $entity */
        return $entity->User;
    }

    public function getContentUrl(Entity $entity): string
    {
        return \XF::app()->router('public')->buildLink('profile-posts', $entity);
    }

    public function getBreadCrumbs(Entity $entity): array
    {
        /** @var \XF\Entity\ProfilePost $entity */
        $router = \XF::app()->router('public');

        return [
            [
                'href'  => $router->buildLink('members', $entity->ProfileUser),
                'value' => $entity->ProfileUser->username
            ],
            [
                'href'  => $router->buildLink('profile-posts', $entity),
                'value' => \XF::Phrase('profile_post_by_x', ['name' => $entity->username])
            ]
        ];
    }

    public function getGiftRoute(): string
    {
        return 'profile-posts/gift';
    }

    public function getGiftsRoute(): string
    {
        return 'profile-posts/gifts';
    }
}