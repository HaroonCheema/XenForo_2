<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePost;

use XenBulletins\BrandHub\Entity\OwnerPagePost;

class Preparer extends \XF\Service\AbstractService
{
	/**
	 * @var OwnerPagePost
	 */
	protected $ownerPagePost;

	protected $attachmentHash;

	protected $logIp = true;

	protected $mentionedUsers = [];

	public function __construct(\XF\App $app, OwnerPagePost $ownerPagePost)
	{
		parent::__construct($app);
		$this->setOwnerPagePost($ownerPagePost);
	}

	protected function setOwnerPagePost(OwnerPagePost $ownerPagePost)
	{
		$this->ownerPagePost = $ownerPagePost;
	}

	public function getOwnerPagePost()
	{
		return $this->ownerPagePost;
	}

	public function logIp($logIp)
	{
		$this->logIp = $logIp;
	}

	public function getMentionedUsers($limitPermissions = true)
	{
		if ($limitPermissions && $this->ownerPagePost)
		{
			/** @var \XF\Entity\User $user */
			$user = $this->ownerPagePost->User ?: $this->repository('XF:User')->getGuestUser();
			return $user->getAllowedUserMentions($this->mentionedUsers);
		}
		else
		{
			return $this->mentionedUsers;
		}
	}

	public function getMentionedUserIds($limitPermissions = true)
	{
		return array_keys($this->getMentionedUsers($limitPermissions));
	}

	public function setMessage($message, $format = true)
	{
		$preparer = $this->getMessagePreparer($format);
		$preparer->setConstraint('maxLength', $this->app->options()->profilePostMaxLength);
		$this->ownerPagePost->message = $preparer->prepare($message);
		$this->ownerPagePost->embed_metadata = $preparer->getEmbedMetadata();

		$this->mentionedUsers = $preparer->getMentionedUsers();

		return $preparer->pushEntityErrorIfInvalid($this->ownerPagePost);
	}

	/**
	 * @param bool $format
	 *
	 * @return \XF\Service\Message\Preparer
	 */
	protected function getMessagePreparer($format = true)
	{
		/** @var \XF\Service\Message\Preparer $preparer */
		$preparer = $this->service('XF:Message\Preparer', 'bh_ownerPage_post', $this->ownerPagePost);
		$preparer->enableFilter('structuredText');
		if (!$format)
		{
			$preparer->disableAllFilters();
		}

		return $preparer;
	}

	public function setAttachmentHash($hash)
	{
		$this->attachmentHash = $hash;
	}

	public function checkForSpam()
	{
		$ownerPagePost = $this->ownerPagePost;

		/** @var \XF\Entity\User $user */
		$user = $ownerPagePost->User ?: $this->repository('XF:User')->getGuestUser($ownerPagePost->username);
		$message = $ownerPagePost->message;

		$checker = $this->app->spam()->contentChecker();
		$checker->check($user, $message, [
			'content_type' => 'bh_ownerPage_post'
		]);

		$decision = $checker->getFinalDecision();
		switch ($decision)
		{
			case 'moderated':
				$ownerPagePost->message_state = 'moderated';
				break;

			case 'denied':
				$checker->logSpamTrigger('bh_ownerPage_post', null);
				$ownerPagePost->error(\XF::phrase('your_content_cannot_be_submitted_try_later'));
				break;
		}
	}

	public function afterInsert()
	{
		if ($this->attachmentHash)
		{
			$this->associateAttachments($this->attachmentHash);
		}

		if ($this->logIp)
		{
			$ip = ($this->logIp === true ? $this->app->request()->getIp() : $this->logIp);
			$this->writeIpLog($ip);
		}

		$checker = $this->app->spam()->contentChecker();
		$checker->logSpamTrigger('bh_ownerPage_post', $this->ownerPagePost->post_id);
	}

	public function afterUpdate()
	{
		if ($this->attachmentHash)
		{
			$this->associateAttachments($this->attachmentHash);
		}

		$checker = $this->app->spam()->contentChecker();
		$checker->logSpamTrigger('bh_ownerPage_post', $this->ownerPagePost->post_id);
	}

	protected function associateAttachments($hash)
	{
		$ownerPagePost = $this->ownerPagePost;

		/** @var \XF\Service\Attachment\Preparer $inserter */
		$inserter = $this->service('XF:Attachment\Preparer');
		$associated = $inserter->associateAttachmentsWithContent($hash, 'bh_ownerPage_post', $ownerPagePost->post_id);
		if ($associated)
		{
			$ownerPagePost->fastUpdate('attach_count', $ownerPagePost->attach_count + $associated);
		}
	}

	protected function writeIpLog($ip)
	{
		$ownerPagePost = $this->ownerPagePost;
		if (!$ownerPagePost->user_id)
		{
			return;
		}

		/** @var \XF\Repository\IP $ipRepo */
		$ipRepo = $this->repository('XF:Ip');
		$ipEnt = $ipRepo->logIp($ownerPagePost->user_id, $ip, 'bh_ownerPage_post', $ownerPagePost->post_id);
		if ($ipEnt)
		{
			$ownerPagePost->fastUpdate('ip_id', $ipEnt->ip_id);
		}
	}
}