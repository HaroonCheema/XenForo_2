<?php
namespace Brivium\AdvancedThreadRating\XF\Pub\Controller;

class Forum extends XFCP_Forum
{

	protected function getAvailableForumSorts(\XF\Entity\Forum $forum)
	{
		$sorts = parent::getAvailableForumSorts($forum);
		$sorts += [
			'rating' => 'brivium_rating_weighted'
		];
		return $sorts;
	}
}