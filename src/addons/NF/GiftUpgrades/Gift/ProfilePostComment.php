<?php

namespace NF\GiftUpgrades\Gift;

use XF\Mvc\Entity\Entity;

/**
 * Class ProfilePostComment
 *
 * @package NF\GiftUpgrades\Gift
 */
class ProfilePostComment extends AbstractHandler
{
    public function getEntityWith(): array
    {
        return ['ProfilePost', 'ProfilePost.ProfileUser', 'ProfilePost.ProfileUser.Privacy'];
    }

    public function getContentUser(Entity $entity): \XF\Entity\User
    {
        /** @var \NF\GiftUpgrades\XF\Entity\ProfilePostComment $entity */
        return $entity->User;
    }

    public function getContentUrl(Entity $entity): string
    {
        return \XF::app()->router('public')->buildLink('profile-posts/comments', $entity);
    }

    public function getBreadCrumbs(Entity $entity): array
    {
        /** @var \XF\Entity\ProfilePostComment $entity */
        $router = \XF::app()->router('public');

        return [
            [
                'href'  => $router->buildLink('members', $entity->ProfilePost->ProfileUser),
                'value' => $entity->ProfilePost->ProfileUser->username
            ],
            [
                'href'  => $router->buildLink('profile-posts', $entity->ProfilePost),
                'value' => \XF::Phrase('profile_post_by_x', ['name' => $entity->ProfilePost->username])
            ],
            [
                'href'  => $router->buildLink('profile-posts/comments', $entity),
                'value' => \XF::Phrase('profile_post_comment_by_x', ['name' => $entity->username])
            ]
        ];
    }

    public function getGiftRoute(): string
    {
        return 'profile-posts/comments-gift';
    }

    public function getGiftsRoute(): string
    {
        return 'profile-posts/comments-gifts';
    }
}