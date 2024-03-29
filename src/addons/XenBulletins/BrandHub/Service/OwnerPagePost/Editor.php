<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePost;

use XenBulletins\BrandHub\Entity\OwnerPagePost;

class Editor extends \XF\Service\AbstractService
{
	use \XF\Service\ValidateAndSavableTrait;

	/**
	 * @var OwnerPagePost
	 */
	protected $ownerPagePost;

	/**
	 * @var \XenBulletins\BrandHub\Service\OwnerPagePost\Preparer
	 */
	protected $preparer;

	protected $alert = false;
	protected $alertReason = '';

	public function __construct(\XF\App $app, OwnerPagePost $ownerPagePost)
	{
		parent::__construct($app);
		$this->setOwnerPagePost($ownerPagePost);
	}

	protected function setOwnerPagePost(OwnerPagePost $ownerPagePost)
	{
		$this->ownerPagePost = $ownerPagePost;
		$this->preparer = $this->service('XenBulletins\BrandHub:OwnerPagePost\Preparer', $ownerPagePost);
	}

	public function getOwnerPagePost()
	{
		return $this->ownerPagePost;
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
		if ($this->ownerPagePost->message_state == 'visible' && \XF::visitor()->isSpamCheckRequired())
		{
			$this->preparer->checkForSpam();
		}
	}

	protected function finalSetup() {}

	protected function _validate()
	{
		$this->finalSetup();

		$this->ownerPagePost->preSave();
		return $this->ownerPagePost->getErrors();
	}

	protected function _save()
	{
		$db = $this->db();
		$db->beginTransaction();

		$ownerPagePost = $this->ownerPagePost;
		$visitor = \XF::visitor();

		$ownerPagePost->save(true, false);

		$this->preparer->afterUpdate();

		if ($ownerPagePost->message_state == 'visible' && $this->alert && $ownerPagePost->user_id != $visitor->user_id)
		{
                        /** @var \XenBulletins\BrandHub\Repository\OwnerPagePost $ownerPagePostRepo */
			$ownerPagePostRepo = $this->repository('XenBulletins\BrandHub:OwnerPagePost');
			$ownerPagePostRepo->sendModeratorActionAlert($ownerPagePost, 'edit', $this->alertReason);
		}

		$db->commit();

		return $ownerPagePost;
	}
}