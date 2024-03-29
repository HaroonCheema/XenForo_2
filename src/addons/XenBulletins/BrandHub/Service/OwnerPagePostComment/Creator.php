<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePostComment;

use XenBulletins\BrandHub\Entity\OwnerPagePost;
use XenBulletins\BrandHub\Entity\OwnerPagePostComment;
use XF\Entity\User;

class Creator extends \XF\Service\AbstractService
{
	use \XF\Service\ValidateAndSavableTrait;

	/**
	 * @var OwnerPagePost
	 */
	protected $ownerPagePost;

	/**
	 * @var OwnerPagePostComment
	 */
	protected $comment;

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Preparer
	 */
	protected $preparer;

	public function __construct(\XF\App $app, OwnerPagePost $ownerPagePost)
	{
		parent::__construct($app);
		$this->setOwnerPagePost($ownerPagePost);
		$this->setUser(\XF::visitor());
		$this->setDefaults();
	}

	protected function setOwnerPagePost(OwnerPagePost $ownerPagePost)
	{
		$this->ownerPagePost = $ownerPagePost;
		$this->comment = $ownerPagePost->getNewComment();
		$this->preparer = $this->service('XenBulletins\BrandHub:OwnerPagePostComment\Preparer', $this->comment);
	}

	public function getOwnerPagePost()
	{
		return $this->ownerPagePost;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function getOwnerPagePostCommentPreparer()
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
		$this->comment->message_state = $this->ownerPagePost->getNewContentState();
		$this->comment->user_id = $this->user->user_id;
		$this->comment->username = $this->user->username;
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
		if ($this->comment->message_state == 'visible' && $this->user->isSpamCheckRequired())
		{
			$this->preparer->checkForSpam();
		}
	}

	protected function finalSetup()
	{
		$this->comment->comment_date = time();
	}

	protected function _validate()
	{
		$this->finalSetup();

		$this->comment->preSave();
		return $this->comment->getErrors();
	}

	protected function _save()
	{
		$comment = $this->comment;
		$comment->save();

		$this->preparer->afterInsert();

		return $comment;
	}

	public function sendNotifications()
	{
		if ($this->comment->isVisible())
		{
			/** @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Notifier $notifier */
			$notifier = $this->service('XenBulletins\BrandHub:OwnerPagePostComment\Notifier', $this->comment);
			$notifier->setNotifyMentioned($this->preparer->getMentionedUserIds());
			$notifier->notify();
		}
	}
}