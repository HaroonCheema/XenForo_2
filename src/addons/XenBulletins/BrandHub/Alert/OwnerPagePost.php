<?php

namespace XenBulletins\BrandHub\Alert;

use XF\Alert\AbstractHandler;

class OwnerPagePost extends AbstractHandler
{
	public function getEntityWith()
	{
		return ['OwnerPage'];
	}

	public function getOptOutActions()
	{
		$visitor = \XF::visitor();

		if ($visitor->canViewOwnerPagePosts())
		{
			return [
				'insert',
				'mention',
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
		return 20051;
	}
}