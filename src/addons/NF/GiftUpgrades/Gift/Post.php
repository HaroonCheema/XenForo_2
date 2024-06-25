<?php

namespace NF\GiftUpgrades\Gift;

use XF\Mvc\Entity\Entity;

/**
 * Class Post
 *
 * @package NF\GiftUpgrades\Gift
 */
class Post extends AbstractHandler
{
	public function getEntityWith(): array
    {
		$visitor = \XF::visitor();

		return ['Thread', 'Thread.Forum', 'Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id];
	}

    public function getContentUser(Entity $entity): \XF\Entity\User
    {
        /** @var \NF\GiftUpgrades\XF\Entity\Post $entity */
        return $entity->User;
    }

    public function getContentUrl(Entity $entity): string
    {
        return \XF::app()->router('public')->buildLink('posts', $entity);
    }

    public function getBreadCrumbs(Entity $entity): array
    {
        /** @var \XF\Entity\Post $entity */
        return $entity->Thread->getBreadcrumbs(true);
    }

    public function getGiftRoute(): string
    {
        return 'posts/gift';
    }

    public function getGiftsRoute(): string
    {
        return 'posts/gifts';
    }
}