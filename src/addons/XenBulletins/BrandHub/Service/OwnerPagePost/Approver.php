<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePost;

use XenBulletins\BrandHub\Entity\OwnerPagePost;

class Approver extends \XF\Service\AbstractService
{
	/**
	 * @var OwnerPagePost
	 */
	protected $ownerPagePost;

	public function __construct(\XF\App $app, OwnerPagePost $ownerPagePost)
	{
		parent::__construct($app);
		$this->ownerPagePost = $ownerPagePost;
	}

	public function getOwnerPagePost()
	{
		return $this->ownerPagePost;
	}

	public function approve()
	{
		if ($this->ownerPagePost->message_state == 'moderated')
		{
			$this->ownerPagePost->message_state = 'visible';
			$this->ownerPagePost->save();

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
		/** @var \XenBulletins\BrandHub\Service\OwnerPagePost\Notifier $notifier */
		$notifier = $this->service('XenBulletins\BrandHub:OwnerPagePost\Notifier', $this->ownerPagePost);
		$notifier->notify();
	}
}