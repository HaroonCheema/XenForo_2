<?php

namespace XenAddons\Showcase\ThreadType;

use XF\Entity\Thread;
use XF\Http\Request;
use XF\ThreadType\AbstractHandler;

class Item extends AbstractHandler
{
	public function getTypeIconClass(): string
	{
		return 'fa-images';
	}

	public function getThreadViewAndTemplate(Thread $thread): array
	{
		return ['XenAddons\Showcase:Thread\ViewTypeItem', 'xa_sc_thread_view_type_item'];
	}

	public function adjustThreadViewParams(Thread $thread, array $viewParams, Request $request): array
	{
		$thread = $viewParams['thread'] ?? null;
		if ($thread)
		{
			/** @var \XenAddons\Showcase\Entity\Item $item */
			$item = \XF::repository('XenAddons\Showcase:Item')->findItemForThread($thread)->fetchOne();
			
			if ($item && $item->canView())
			{
				$trimmedItem = null;
				if (!$item->canViewFullItem())
				{
					$snippet = \XF::app()->stringFormatter()->wholeWordTrim($item->message, \XF::app()->options()->xaScLimitedViewItemLength);
					$trimmedItem = \XF::app()->bbCode()->render($snippet, 'bbCodeClean', 'sc_item', null);
				}

				$viewParams['scItem'] = $item;
				$viewParams['scTrimmedItem'] = $trimmedItem;
			}
		}

		return $viewParams;
	}

	public function allowExternalCreation(): bool
	{
		return false;
	}
	
	public function canThreadTypeBeChanged(Thread $thread): bool
	{
		return false;
	}
	
	public function canConvertThreadToType(bool $isBulk): bool
	{
		return false;
	}
}