<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePost;

use XF\Entity\User;
use XenBulletins\BrandHub\Entity\OwnerPage;
use XenBulletins\BrandHub\Entity\OwnerPagePost;

class Creator extends \XF\Service\AbstractService
{
	use \XF\Service\ValidateAndSavableTrait;

	/**
	 * @var OwnerPage
	 */
	protected $ownerPage;

	/**
	 * @var OwnerPagePost
	 */
	protected $ownerPagePost;

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var XenBulletins\BrandHub\Service\OwnerPagePost\Preparer
	 */
	protected $preparer;

	public function __construct(\XF\App $app, OwnerPage $ownerPage)
	{
		parent::__construct($app);
		$this->setOwnerPage($ownerPage);
		$this->setUser(\XF::visitor());
		$this->setDefaults();
	}

	protected function setOwnerPage(OwnerPage $ownerPage)
	{
		$this->ownerPage = $ownerPage;
		$this->ownerPagePost = $ownerPage->getNewOwnerPagePost();
		$this->preparer = $this->service('XenBulletins\BrandHub:OwnerPagePost\Preparer', $this->ownerPagePost);
	}

	public function getOwnerPage()
	{
		return $this->ownerPage;
	}

	public function getOwnerPagePost()
	{
		return $this->ownerPagePost;
	}

	public function getOwnerPagePostPreparer()
	{
		return $this->preparer;
	}

	public function logIp($logIp)
	{
		$this->preparer->logIp($logIp);
	}

	protected function setUser(\XF\Entity\User $user)
	{
		$this->user = $user;
	}

	protected function setDefaults()
	{
		$this->ownerPagePost->message_state = $this->ownerPagePost->getNewContentState();
		$this->ownerPagePost->user_id = $this->user->user_id;
		$this->ownerPagePost->username = $this->user->username;
	}

	public function setContent($message, $format = true)
	{
		return $this->preparer->setMessage($message, $format);
	}

	public function setAttachmentHash($hash)
	{
		$this->preparer->setAttachmentHash($hash);
	}

	public function checkForSpam()
	{
		if ($this->ownerPagePost->message_state == 'visible' && $this->user->isSpamCheckRequired())
		{
			$this->preparer->checkForSpam();
		}
	}

	protected function finalSetup()
	{
		$this->ownerPagePost->post_date = time();
	}

	protected function _validate()
	{
		$this->finalSetup();

		$this->ownerPagePost->preSave();
		return $this->ownerPagePost->getErrors();
	}

	protected function _save()
	{
		$ownerPagePost = $this->ownerPagePost;
		$ownerPagePost->save();

		$this->preparer->afterInsert();

		return $ownerPagePost;
	}

	public function sendNotifications()
	{
		if ($this->ownerPagePost->isVisible())
		{
			/** @var \XenBulletins\BrandHub\Service\OwnerPagePost\Notifier $notifier */
			$notifier = $this->service('XenBulletins\BrandHub:OwnerPagePost\Notifier', $this->ownerPagePost);
			$notifier->setNotifyMentioned($this->preparer->getMentionedUserIds());
			$notifier->notify();
		}
	}
}