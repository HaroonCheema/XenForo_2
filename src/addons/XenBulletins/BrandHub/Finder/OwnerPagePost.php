<?php

namespace XenBulletins\BrandHub\Finder;

use XF\Mvc\Entity\Finder;

class OwnerPagePost extends Finder
{
	/**
	 * @deprecated Use with('full') or with('fullOwnerPage')
	 *
	 * @param bool $withOwnerPage
	 *
	 * @return $this
	 */
	public function forFullView($withOwnerPage = false)
	{
		$this->with($withOwnerPage ? 'fullOwnerPage' : 'full');

		return $this;
	}

	public function onOwnerPage(\XenBulletins\BrandHub\Entity\OwnerPage $ownerPage, array $limits = [])
	{
		$limits = array_replace([
			'visibility' => true,
			'allowOwnPending' => true
		], $limits);

		$this->where('owner_page_id', $ownerPage->page_id);

		if ($limits['visibility'])
		{
			$this->applyVisibilityChecksForOwnerPage($ownerPage, $limits['allowOwnPending']);
		}

		$this->with('full');

		return $this;
	}

	public function applyVisibilityChecksForOwnerPage(\XenBulletins\BrandHub\Entity\OwnerPage $ownerPage, $allowOwnPending = true)
	{
		$conditions = [];
		$viewableStates = ['visible'];

		if ($ownerPage->canViewDeletedPostsOnOwnerPage())
		{
			$viewableStates[] = 'deleted';
			$this->with('DeletionLog');
		}

		$visitor = \XF::visitor();
		if ($ownerPage->canViewModeratedPostsOnOwnerPage())
		{
			$viewableStates[] = 'moderated';
		}
		else if ($visitor->user_id && $allowOwnPending)
		{
			$conditions[] = [
				'message_state' => 'moderated',
				'user_id' => $visitor->user_id
			];
		}

		$conditions[] = ['message_state', $viewableStates];

		$this->whereOr($conditions);

		return $this;
	}

	public function newerThan($date)
	{
		$this->where('post_date', '>', $date);

		return $this;
	}
}