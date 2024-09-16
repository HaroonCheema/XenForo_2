<?php
namespace Brivium\AdvancedThreadRating\Alert\Thread;

use XF\Alert\AbstractHandler;

class Rating extends AbstractHandler
{

	public function getEntityWith()
	{
		$visitor = \XF::visitor();

		return ['Thread', 'Thread.Forum', 'Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id];
	}

	public function getOptOutActions()
	{
		return [
			'insert',
			'like'
		];
	}

	public function getOptOutDisplayOrder()
	{
		return 100;
	}
}