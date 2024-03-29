<?php

namespace XenBulletins\BrandHub\Finder;

use XF\Mvc\Entity\Finder;

class OwnerPagePostComment extends Finder
{
	/**
	 * @deprecated Use with('full')
	 *
	 * @return $this
	 */
	public function forFullView()
	{
		$this->with('full');

		return $this;
	}

	public function forOwnerPagePost(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost, array $limits = [])
	{
		$limits = array_replace([
			'visibility' => true,
			'allowOwnPending' => true
		], $limits);

		$this->where('post_id', $ownerPagePost->post_id);

		if ($limits['visibility'])
		{
			$this->applyVisibilityChecksForOwnerPagePost($ownerPagePost, $limits['allowOwnPending']);
		}

		return $this;
	}

	public function applyVisibilityChecksForOwnerPagePost(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost, $allowOwnPending = true)
	{
		$conditions = [];
		$viewableStates = ['visible'];

		if ($ownerPagePost->canViewDeletedComments())
		{
			$viewableStates[] = 'deleted';
			$this->with('DeletionLog');
		}

		$visitor = \XF::visitor();
		if ($ownerPagePost->canViewModeratedComments())
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
		$this->where('comment_date', '>', $date);

		return $this;
	}
}