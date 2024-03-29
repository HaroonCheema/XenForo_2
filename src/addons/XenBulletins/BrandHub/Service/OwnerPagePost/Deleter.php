<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePost;

use XenBulletins\BrandHub\Entity\OwnerPagePost;
use XF\Entity\User;

class Deleter extends \XF\Service\AbstractService
{
	/**
	 * @var OwnerPagePost
	 */
	protected $ownerPagePost;

	/**
	 * @var User
	 */
	protected $user;

	protected $alert = false;
	protected $alertReason = '';

	public function __construct(\XF\App $app, OwnerPagePost $ownerPagePost)
	{
		parent::__construct($app);
		$this->setOwnerPagePost($ownerPagePost);
		$this->setUser(\XF::visitor());
	}

	protected function setOwnerPagePost(OwnerPagePost $ownerPagePost)
	{
		$this->ownerPagePost = $ownerPagePost;
	}

	public function getOwnerPagePost()
	{
		return $this->ownerPagePost;
	}

	protected function setUser(\XF\Entity\User $user)
	{
		$this->user = $user;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function setSendAlert($alert, $reason = null)
	{
		$this->alert = (bool)$alert;
		if ($reason !== null)
		{
			$this->alertReason = $reason;
		}
	}

	public function delete($type, $reason = '')
	{
		$user = $this->user;

		$ownerPagePost = $this->ownerPagePost;
		$wasVisible = ($ownerPagePost->message_state == 'visible');

		if ($type == 'soft')
		{
			$result = $ownerPagePost->softDelete($reason, $user);
		}
		else
		{
			$result = $ownerPagePost->delete();
		}

		if ($result && $wasVisible && $this->alert && $ownerPagePost->user_id != $user->user_id)
		{
			/** @var \XenBulletins\BrandHub\Repository\OwnerPagePost $ownerPagePostRepo */
			$ownerPagePostRepo = $this->repository('XenBulletins\BrandHub:OwnerPagePost');
			$ownerPagePostRepo->sendModeratorActionAlert($ownerPagePost, 'delete', $this->alertReason);
		}

		return $result;
	}
}