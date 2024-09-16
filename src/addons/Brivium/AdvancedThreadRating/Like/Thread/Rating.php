<?php
namespace Brivium\AdvancedThreadRating\Like\Thread;

class Rating extends \XF\Like\AbstractHandler
{

	public function likesCounted(\XF\Mvc\Entity\Entity $entity)
	{
		if (!$entity->Thread || !$entity->Thread->Forum)
		{
			return false;
		}

		return ($entity->rating_status && $entity->Thread->discussion_state == 'visible');
	}

	public function getEntityWith()
	{
		$visitor = \XF::visitor();

		return ['Thread', 'Thread.Forum', 'Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id];
	}
}