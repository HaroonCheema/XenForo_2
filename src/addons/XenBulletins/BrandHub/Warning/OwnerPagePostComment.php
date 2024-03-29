<?php

namespace XenBulletins\BrandHub\Warning;

use XF\Entity\Warning;
use XF\Mvc\Entity\Entity;
use XF\Warning\AbstractHandler;

class OwnerPagePostComment extends AbstractHandler
{
	public function getStoredTitle(Entity $entity)
	{
		return $entity->User ? $entity->User->username : '';
	}

	public function getDisplayTitle($title)
	{
		return \XF::phrase('owner_page_post_comment_by_x', ['username' => $title]);
	}

	public function getContentForConversation(Entity $entity)
	{
		return $entity->message;
	}

	public function getContentUrl(Entity $entity, $canonical = false)
	{
		return \XF::app()->router('public')->buildLink(($canonical ? 'canonical:' : '') . 'owner-page-posts/comments', $entity);
	}

	public function getContentUser(Entity $entity)
	{
		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $entity */
		return $entity->User;
	}

	public function canViewContent(Entity $entity, &$error = null)
	{
		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $entity */
		return $entity->canView();
	}

	public function onWarning(Entity $entity, Warning $warning)
	{
		$entity->warning_id = $warning->warning_id;
		$entity->save();
	}

	public function onWarningRemoval(Entity $entity, Warning $warning)
	{
		$entity->warning_id = 0;
		$entity->warning_message = '';
		$entity->save();
	}

	public function takeContentAction(Entity $entity, $action, array $options)
	{
		if ($action == 'public')
		{
			$message = $options['message'] ?? '';
			if (is_string($message) && strlen($message))
			{
				$entity->warning_message = $message;
				$entity->save();
			}
		}
		else if ($action == 'delete')
		{
			$reason = $options['reason'] ?? '';
			if (!is_string($reason))
			{
				$reason = '';
			}

			/** @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Deleter $deleter */
			$deleter = \XF::app()->service('XenBulletins\BrandHub:OwnerPagePostComment\Deleter', $entity);
			$deleter->delete('soft', $reason);
		}
	}

	protected function canWarnPublicly(Entity $entity)
	{
		return true;
	}

	protected function canDeleteContent(Entity $entity)
	{
		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $entity */
		return $entity->canDelete('soft');
	}

	public function getEntityWith()
	{
		return ['OwnerPagePost', 'OwnerPagePost.OwnerPage'];
	}
}