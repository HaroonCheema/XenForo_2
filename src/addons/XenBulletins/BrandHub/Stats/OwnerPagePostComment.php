<?php

namespace XenBulletins\BrandHub\Stats;

use XF\Stats\AbstractHandler;

class OwnerPagePostComment extends AbstractHandler
{
	public function getStatsTypes()
	{
		return [
			'owner_page_post_comment' => \XF::phrase('bh_owner_page_post_comments'),
			'owner_page_post_comment_reaction' => \XF::phrase('bh_owner_page_post_comment_reactions')
		];
	}

	public function getData($start, $end)
	{
		$db = $this->db();

		$ownerPagePostsComments = $db->fetchPairs(
			$this->getBasicDataQuery('bh_owner_page_post_comment', 'comment_date', 'message_state = ?'),
			[$start, $end, 'visible']
		);

		$ownerPagePostsCommentReactions = $db->fetchPairs(
			$this->getBasicDataQuery('xf_reaction_content', 'reaction_date', 'content_type = ? AND is_counted = ?'),
			[$start, $end, 'bh_ownerPage_post_comment', 1]
		);

		return [
			'owner_page_post_comment' => $ownerPagePostsComments,
			'owner_page_post_comment_reaction' => $ownerPagePostsCommentReactions
		];
	}
}