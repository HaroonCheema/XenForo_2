<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePostComment;

use XenBulletins\BrandHub\Entity\OwnerPagePostComment;

class Approver extends \XF\Service\AbstractService
{
	/**
	 * @var OwnerPagePostComment
	 */
	protected $comment;

	protected $notifyRunTime = 3;

	public function __construct(\XF\App $app, OwnerPagePostComment $comment)
	{
		parent::__construct($app);
		$this->comment = $comment;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function setNotifyRunTime($time)
	{
		$this->notifyRunTime = $time;
	}

	public function approve()
	{
		if ($this->comment->message_state == 'moderated')
		{
			$this->comment->message_state = 'visible';
			$this->comment->save();

			$this->onApprove();
			return true;
		}
		else
		{
			return false;
		}
	}

	protected function onApprove()
	{
		if ($this->comment->isLastComment())
		{
			/** @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Notifier $notifier */
			$notifier = $this->service('\XenBulletins\BrandHub:OwnerPagePostComment\Notifier', $this->comment);
			$notifier->notify();
		}
	}
}