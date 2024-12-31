<?php

namespace OzzModz\Badges\Finder;

class UserBadge extends \XF\Mvc\Entity\Finder
{
	public function forUser($userId)
	{
		if ($userId instanceof \XF\Entity\User)
		{
			$userId = $userId->user_id;
		}

		$this->where('user_id', $userId);
		return $this;
	}

	public function onlyFeatured()
	{
		$this->where('featured', 1);
		return $this;
	}

	public function useDisplayOrder()
	{
		$this->order(['Badge.Category.display_order', 'Badge.display_order']);
		return $this;
	}
}