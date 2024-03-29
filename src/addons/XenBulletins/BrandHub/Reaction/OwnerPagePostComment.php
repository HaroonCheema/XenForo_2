<?php

namespace XenBulletins\BrandHub\Reaction;

use XF\Mvc\Entity\Entity;
use XF\Reaction\AbstractHandler;

class OwnerPagePostComment extends AbstractHandler
{
	public function reactionsCounted(Entity $entity)
	{
		return ($entity->message_state == 'visible');
	}

	public function getEntityWith()
	{
		return ['OwnerPagePost', 'OwnerPagePost.OwnerPage'];
	}
}