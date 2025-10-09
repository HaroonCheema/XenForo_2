<?php

namespace XenAddons\Showcase\Service\ItemUpdateReply;

use XenAddons\Showcase\Entity\ItemUpdateReply;

class Editor extends \XF\Service\AbstractService
{
	use \XF\Service\ValidateAndSavableTrait;

	/**
	 * @var ItemUpdateReply
	 */
	protected $reply;

	/**
	 * @var \XenAddons\Showcase\Service\ItemUpdateReply\Preparer
	 */
	protected $preparer;

	protected $alert = false;
	protected $alertReason = '';

	public function __construct(\XF\App $app, ItemUpdateReply $reply)
	{
		parent::__construct($app);
		$this->setReply($reply);
	}

	protected function setReply(ItemUpdateReply $reply)
	{
		$this->reply = $reply;
		$this->preparer = $this->service('XenAddons\Showcase:ItemUpdateReply\Preparer', $this->reply);
	}

	public function getReply()
	{
		return $this->reply;
	}

	public function getPreparer()
	{
		return $this->preparer;
	}

	public function setMessage($message, $format = true)
	{
		return $this->preparer->setMessage($message, $format);
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
		if ($this->reply->reply_state == 'visible' && \XF::visitor()->isSpamCheckRequired())
		{
			$this->preparer->checkForSpam();
		}
	}

	protected function finalSetup() {}

	protected function _validate()
	{
		$this->finalSetup();

		$this->reply->preSave();
		return $this->reply->getErrors();
	}

	protected function _save()
	{
		$db = $this->db();
		$db->beginTransaction();

		$reply = $this->reply;
		$visitor = \XF::visitor();

		$reply->save(true, false);

		$this->preparer->afterUpdate();

		if ($reply->reply_state == 'visible' && $this->alert && $reply->user_id != $visitor->user_id)
		{
			/** @var \XenAddons\Showcase\Repository\ItemUpdate $updateRepo */
			$updateRepo = $this->repository('XenAddons\Showcase:ItemUpdate');
			$updateRepo->sendReplyModeratorActionAlert($reply, 'edit', $this->alertReason);
		}

		$db->commit();

		return $reply;
	}
}