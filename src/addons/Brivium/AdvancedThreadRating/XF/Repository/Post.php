<?php
namespace Brivium\AdvancedThreadRating\XF\Repository;

class Post extends XFCP_Post
{

	protected static $userReplied = [];
	public function countRepliedInThreadByUserId($userId, $threadId)
	{
		if(!isset(self::$userReplied[$userId]))
		{
			self::$userReplied[$userId] = $this->db()->fetchPairs('
				SELECT thread_id, COUNT(post_id)
				FROM xf_post
				WHERE (user_id = ?) AND (message_state <> ?)
				GROUP BY thread_id
			', [$userId, 'delete']);
		}

		if(!empty(self::$userReplied[$userId][$threadId]))
		{
			return self::$userReplied[$userId][$threadId];
		}
		return 0;
	}
}