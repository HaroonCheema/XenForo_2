<?php

namespace XenBulletins\BrandHub\ApprovalQueue;

use XF\Mvc\Entity\Entity;
use XF\ApprovalQueue\AbstractHandler;

class OwnerPagePost extends AbstractHandler
{
	protected function canActionContent(Entity $content, &$error = null)
	{
		/** @var $content \XenBulletins\BrandHub\Entity\OwnerPagePost */
		return $content->canApproveUnapprove($error);
	}

	public function actionApprove(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost)
	{
		/** @var \XenBulletins\BrandHub\Service\OwnerPagePost\Approver $approver */
		$approver = \XF::service('XenBulletins\BrandHub:OwnerPagePost\Approver', $ownerPagePost);
		$approver->approve();
	}

	public function actionDelete(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost)
	{
		$this->quickUpdate($ownerPagePost, 'message_state', 'deleted');
	}

	public function actionSpamClean(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost)
	{
		if (!$ownerPagePost->User)
		{
			return;
		}

		$this->_spamCleanInternal($ownerPagePost->User);
	}

	public function getEntityWith()
	{
		return ['OwnerPage'];
	}
}