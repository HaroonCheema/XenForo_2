<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePostComment;

use XenBulletins\BrandHub\Entity\OwnerPagePostComment;

class Editor extends \XF\Service\AbstractService
{
	use \XF\Service\ValidateAndSavableTrait;

	/**
	 * @var OwnerPagePostComment
	 */
	protected $comment;

	/**
	 * @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Preparer
	 */
	protected $preparer;

	protected $alert = false;
	protected $alertReason = '';

	public function __construct(\XF\App $app, OwnerPagePostComment $comment)
	{
		parent::__construct($app);
		$this->setComment($comment);
	}

	protected function setComment(OwnerPagePostComment $comment)
	{
		$this->comment = $comment;
		$this->preparer = $this->service('XenBulletins\BrandHub:OwnerPagePostComment\Preparer', $this->comment);
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function getPreparer()
	{
		return $this->preparer;
	}

	public function setMessage($message, $format = true)
	{
		return $this->preparer->setMessage($message, $format);
	}

	public function setAttachmentHash($hash)
	{
		$this->preparer->setAttachmentHash($hash);
	}

	public function setSendAlert($alert, $reason = null)
	{
		$this->alert = (bool)$alert;
		if ($reason !== null)
		{
			$this->alertReason = $reason;
		}
	}

	public function checkForSpam()
	{
		if ($this->comment->message_state == 'visible' && \XF::visitor()->isSpamCheckRequired())
		{
			$this->preparer->checkForSpam();
		}
	}

	protected function finalSetup() {}

	protected function _validate()
	{
		$this->finalSetup();

		$this->comment->preSave();
		return $this->comment->getErrors();
	}

	protected function _save()
	{
		$db = $this->db();
		$db->beginTransaction();

		$comment = $this->comment;
		$visitor = \XF::visitor();

		$comment->save(true, false);

		$this->preparer->afterUpdate();

		if ($comment->message_state == 'visible' && $this->alert && $comment->user_id != $visitor->user_id)
		{
			/** @var \XenBulletins\BrandHub\Repository\OwnerPagePost $ownerPagePostRepo */
			$ownerPagePostRepo = $this->repository('XenBulletins\BrandHub:OwnerPagePost');
			$ownerPagePostRepo->sendCommentModeratorActionAlert($comment, 'edit', $this->alertReason);
		}

		$db->commit();

		return $comment;
	}
}