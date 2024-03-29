<?php

namespace XenBulletins\BrandHub\Stats;

use XF\Stats\AbstractHandler;

class OwnerPagePost extends AbstractHandler
{
	public function getStatsTypes()
	{
		return [
			'owner_page_post' => \XF::phrase('bh_owner_page_posts'),
			'owner_page_post_reaction' => \XF::phrase('bh_owner_page_post_reactions')
		];
	}

	public function getData($start, $end)
	{
		$db = $this->db();

		$ownerPagePosts = $db->fetchPairs(
			$this->getBasicDataQuery('bh_owner_page_post', 'post_date', 'message_state = ?'),
			[$start, $end, 'visible']
		);

		$ownerPagePostsReactions = $db->fetchPairs(
			$this->getBasicDataQuery('xf_reaction_content', 'reaction_date', 'content_type = ? AND is_counted = ?'),
			[$start, $end, 'bh_ownerPage_post', 1]
		);

		return [
			'owner_page_post' => $ownerPagePosts,
			'owner_page_post_reaction' => $ownerPagePostsReactions
		];
	}
}