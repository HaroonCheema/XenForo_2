<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePostComment;

use XenBulletins\BrandHub\Entity\OwnerPagePostComment;

class Preparer extends \XF\Service\AbstractService
{
    
    
	/**
	 * @var OwnerPagePostComment
	 */
	protected $comment;

	protected $attachmentHash;

	protected $logIp = true;

	protected $mentionedUsers = [];

	public function __construct(\XF\App $app, OwnerPagePostComment $comment)
	{
		parent::__construct($app);
		$this->setComment($comment);
	}

	protected function setComment(OwnerPagePostComment $comment)
	{
		$this->comment = $comment;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function logIp($logIp)
	{
		$this->logIp = $logIp;
	}

	public function getMentionedUsers($limitPermissions = true)
	{
		if ($limitPermissions && $this->comment)
		{
			/** @var \XF\Entity\User $user */
			$user = $this->comment->User ?: $this->repository('XF:User')->getGuestUser();
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
		$this->comment->message = $preparer->prepare($message);
		$this->comment->embed_metadata = $preparer->getEmbedMetadata();

		$this->mentionedUsers = $preparer->getMentionedUsers();

		return $preparer->pushEntityErrorIfInvalid($this->comment);
	}

	/**
	 * @param bool $format
	 *
	 * @return \XF\Service\Message\Preparer
	 */
	protected function getMessagePreparer($format = true)
	{
		/** @var \XF\Service\Message\Preparer $preparer */
		$preparer = $this->service('XF:Message\Preparer', 'bh_ownerPage_post_comment', $this->comment);
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
		$comment = $this->comment;

		/** @var \XF\Entity\User $user */
		$user = $comment->User ?: $this->repository('XF:User')->getGuestUser($comment->username);
		$message = $comment->message;

		$checker = $this->app->spam()->contentChecker();
		$checker->check($user, $message, [
			'content_type' => 'bh_ownerPage_post_comment'
		]);

		$decision = $checker->getFinalDecision();
		switch ($decision)
		{
			case 'moderated':
				$comment->message_state = 'moderated';
				break;

			case 'denied':
				$checker->logSpamTrigger('bh_ownerPage_post_comment', null);
				$comment->error(\XF::phrase('your_content_cannot_be_submitted_try_later'));
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
		$checker->logSpamTrigger('bh_ownerPage_post_comment', $this->comment->post_comment_id);
	}

	public function afterUpdate()
	{
		if ($this->attachmentHash)
		{
			$this->associateAttachments($this->attachmentHash);
		}

		$checker = $this->app->spam()->contentChecker();
		$checker->logSpamTrigger('bh_ownerPage_post_comment', $this->comment->post_comment_id);
	}

	protected function associateAttachments($hash)
	{
		$comment = $this->comment;

		/** @var \XF\Service\Attachment\Preparer $inserter */
		$inserter = $this->service('XF:Attachment\Preparer');
		$associated = $inserter->associateAttachmentsWithContent($hash, 'bh_ownerPage_post_comment', $comment->post_comment_id);
		if ($associated)
		{
			$comment->fastUpdate('attach_count', $comment->attach_count + $associated);
		}
	}

	protected function writeIpLog($ip)
	{
		$comment = $this->comment;
		if (!$comment->user_id)
		{
			return;
		}

		/** @var \XF\Repository\IP $ipRepo */
		$ipRepo = $this->repository('XF:Ip');
		$ipEnt = $ipRepo->logIp($comment->user_id, $ip, 'bh_ownerPage_post_comment', $comment->post_comment_id);
		if ($ipEnt)
		{
			$comment->fastUpdate('ip_id', $ipEnt->ip_id);
		}
	}
}