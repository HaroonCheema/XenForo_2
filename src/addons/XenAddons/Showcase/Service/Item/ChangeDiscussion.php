<?php

namespace XenAddons\Showcase\Service\Item;

use XenAddons\Showcase\Entity\Item;

class ChangeDiscussion extends \XF\Service\AbstractService
{
	/**
	 * @var \XenAddons\Showcase\Entity\Item
	 */
	protected $item;

	public function __construct(\XF\App $app, Item $item)
	{
		parent::__construct($app);
		$this->item = $item;
	}

	public function getItem()
	{
		return $this->item;
	}

	public function disconnectDiscussion()
	{
		$this->item->discussion_thread_id = 0;
		$this->item->save();

		return true;
	}

	public function changeThreadByUrl($threadUrl, $checkPermissions = true, &$error = null)
	{
		$threadRepo = $this->repository('XF:Thread');
		$thread = $threadRepo->getThreadFromUrl($threadUrl, null, $threadFetchError);
		if (!$thread)
		{
			$error = $threadFetchError;
			return false;
		}

		return $this->changeThreadTo($thread, $checkPermissions, $error);
	}

	public function changeThreadTo(\XF\Entity\Thread $thread, $checkPermissions = true, &$error = null)
	{
		if ($checkPermissions && !$thread->canView($viewError))
		{
			$error = $viewError ?: \XF::phrase('do_not_have_permission');
			return false;
		}

		if ($thread->thread_id === $this->item->discussion_thread_id)
		{
			return true;
		}

		if ($thread->discussion_type != \XF\ThreadType\AbstractHandler::BASIC_THREAD_TYPE)
		{
			$error = \XF::phrase('xa_sc_new_item_discussion_thread_must_be_standard_thread');
			return false;
		}

		$this->item->discussion_thread_id = $thread->thread_id;
		$this->item->save();

		return true;
	}

}