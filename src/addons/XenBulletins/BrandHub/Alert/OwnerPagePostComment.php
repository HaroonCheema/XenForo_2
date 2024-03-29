<?php

namespace XenBulletins\BrandHub\Alert;

use XF\Alert\AbstractHandler;

class OwnerPagePostComment extends AbstractHandler
{
	public function getOptOutActions()
	{
		$visitor = \XF::visitor();

		if ($visitor->canViewOwnerPagePosts())
		{
			return [
				'your_owner_page',
				'your_post',
				'other_commenter',
				'reaction'
			];
		}
		else
		{
			return [];
		}
	}

	public function getOptOutDisplayOrder()
	{
		return 20052;
	}
}