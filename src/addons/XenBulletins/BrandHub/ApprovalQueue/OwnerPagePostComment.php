<?php

namespace XenBulletins\BrandHub\ApprovalQueue;

use XF\Mvc\Entity\Entity;
use XF\ApprovalQueue\AbstractHandler;

class OwnerPagePostComment extends AbstractHandler
{
	protected function canActionContent(Entity $content, &$error = null)
	{
		/** @var $content \XenBulletins\BrandHub\Entity\OwnerPagePostComment */
		return $content->canApproveUnapprove($error);
	}

	public function actionApprove(\XenBulletins\BrandHub\Entity\OwnerPagePostComment $comment)
	{
		/** @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Approver $approver */
		$approver = \XF::service('XenBulletins\BrandHub:OwnerPagePostComment\Approver', $comment);
		$approver->approve();
	}

	public function actionDelete(\XenBulletins\BrandHub\Entity\OwnerPagePostComment $comment)
	{
		$this->quickUpdate($comment, 'message_state', 'deleted');
	}

	public function actionSpamClean(\XenBulletins\BrandHub\Entity\OwnerPagePostComment $comment)
	{
		if (!$comment->User)
		{
			return;
		}

		$this->_spamCleanInternal($comment->User);
	}
}