<?php

namespace XenAddons\Showcase\Service\Item;

use XenAddons\Showcase\Entity\Item;

class PublishDraft extends \XF\Service\AbstractService
{
	/**
	 * @var Item
	 */
	protected $item;

	protected $notifyRunTime = 3;

	public function __construct(\XF\App $app, Item $item)
	{
		parent::__construct($app);
		$this->item = $item;
	}

	public function getItem()
	{
		return $this->item;
	}

	public function setNotifyRunTime($time)
	{
		$this->notifyRunTime = $time;
	}

	public function publishDraft($isAutomated = false)
	{
		if ($this->item->item_state == 'draft' || $this->item->item_state == 'awaiting')
		{
			if ($isAutomated)
			{
				// TODO for now, set this to visible... in the future, check the item authors permissions on whether to bypass queue or not
				$this->item->item_state = 'visible';
			}
			else
			{
				$this->item->item_state = $this->item->Category->getNewItemState();
			}

			$this->item->create_date = \XF::$time;
			$this->item->edit_date = \XF::$time;
			$this->item->last_update = \XF::$time;
			$this->item->save();

			$this->onPublishDraft();
			
			return true;
		}
		else
		{
			return false;
		}
	}

	protected function onPublishDraft()
	{
		$visitor = \XF::visitor();
		$item = $this->item;

		if ($item)
		{
			if ($item->item_state == 'visible')
			{
				/** @var \XenAddons\Showcase\Service\Item\Notify $notifier */
				$notifier = $this->service('XenAddons\Showcase:Item\Notify', $item, 'item');
				$notifier->notifyAndEnqueue($this->notifyRunTime);
			}
			
			if ($item->Discussion && $item->Discussion->discussion_type == 'sc_item')
			{
				$thread = $item->Discussion;
	
				if ($item->item_state == 'visible')
				{
					$thread->discussion_state = 'visible';
					$thread->discussion_open = true;
				}
					
				$thread->post_date = \XF::$time;
				
				if ($thread->last_post_id == $thread->first_post_id)
				{
					$thread->last_post_date = \XF::$time;
				}
				
				$thread->saveIfChanged($saved, false, false);
	
				$firstPost = $thread->FirstPost;
				$firstPost->post_date = \XF::$time;
				$firstPost->saveIfChanged($saved, false, false);
			}
		}	
	}
}