<?php

namespace XenBulletins\BrandHub\InlineMod;


use XF\Mvc\Entity\Entity;
use XF\InlineMod\AbstractHandler;

class OwnerPagePost extends AbstractHandler
{
	public function getPossibleActions()
	{
		$actions = [];

		$actions['delete'] = $this->getActionHandler('XenBulletins\BrandHub:OwnerPagePost\Delete');

		$actions['undelete'] = $this->getSimpleActionHandler(
			\XF::phrase('undelete_posts'),
			'canUndelete',
			function(Entity $entity)
			{
				/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $entity */
				if ($entity->message_state == 'deleted')
				{
					$entity->message_state = 'visible';
					$entity->save();
				}
			}
		);

		$actions['approve'] = $this->getSimpleActionHandler(
			\XF::phrase('approve_posts'),
			'canApproveUnapprove',
			function(Entity $entity)
			{
				/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $entity */
				if ($entity->message_state == 'moderated')
				{
					/** @var \XenBulletins\BrandHub\Service\OwnerPagePost\Approver $approver */
					$approver = \XF::service('XenBulletins\BrandHub:OwnerPagePost\Approver', $entity);
					$approver->approve();
				}
			}
		);

		$actions['unapprove'] = $this->getSimpleActionHandler(
			\XF::phrase('unapprove_posts'),
			'canApproveUnapprove',
			function(Entity $entity)
			{
				/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $entity */
				if ($entity->message_state == 'visible')
				{
					$entity->message_state = 'moderated';
					$entity->save();
				}
			}
		);

		return $actions;
	}

	public function getEntityWith()
	{
		return ['OwnerPage'];
	}
}