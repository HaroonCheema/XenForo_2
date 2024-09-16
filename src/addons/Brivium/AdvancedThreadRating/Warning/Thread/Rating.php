<?php
namespace Brivium\AdvancedThreadRating\Warning\Thread;

use XF\Entity\Warning;
use XF\Mvc\Entity\Entity;
use XF\Warning\AbstractHandler;

class Rating extends AbstractHandler
{

	public function getStoredTitle(Entity $entity)
	{
		return $entity->Thread ? $entity->Thread->title : '';
	}

	public function getDisplayTitle($title)
	{
		return \XF::phrase('BRATR_rated_in_thread_x', ['title' => $title]);
	}

	public function getContentForConversation(Entity $entity)
	{
		return $entity->message;
	}

	public function getContentUrl(Entity $entity, $canonical = false)
	{
		return \XF::app()->router('public')->buildLink(($canonical ? 'canonical:' : '') . 'bratr-ratings', $entity);
	}

	public function getContentUser(Entity $entity)
	{
		/** @var \Brivium\AdvancedThreadRating\Entity\Rating $entity */
		return $entity->User;
	}

	public function canViewContent(Entity $entity, &$error = NULL)
	{
		/** @var \Brivium\AdvancedThreadRating\Entity\Rating $entity */
		return $entity->canView();
	}

	public function onWarning(Entity $entity, \XF\Entity\Warning $warning)
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
			$message = isset($options['message']) ? $options['message'] : '';
			if (is_string($message) && strlen($message))
			{
				$entity->warning_message = $message;
				$entity->save();
			}
		}
		else if ($action == 'delete')
		{
			$reason = isset($options['reason']) ? $options['reason'] : '';
			if (!is_string($reason))
			{
				$reason = '';
			}

			/** @var \Brivium\AdvancedThreadRating\Entity\Rating $entity */
			$entity->softDelete($reason);
		}
	}

	protected function canWarnPublicly(Entity $entity)
	{
		return true;
	}

	protected function canDeleteContent(Entity $entity)
	{
		/** @var \Brivium\AdvancedThreadRating\Entity\Rating $entity */
		return $entity->canDelete('soft');
	}

	public function getEntityWith()
	{
		$visitor = \XF::visitor();
		return ['Thread', 'Thread.Forum', 'Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id];
	}
}