<?php

namespace FS\DeleteQuotedPosts\Job;

use XF\Job\AbstractJob;
use XF\Job\AbstractRebuildJob;

class DeleteQuotedPosts extends AbstractRebuildJob
{
	protected function getNextIds($start, $batch)
	{
		$db = $this->app->db();

		return $db->fetchAllColumn($db->limit(
			"
				SELECT thread_id
				FROM xf_thread
				WHERE thread_id > ?
				ORDER BY thread_id
			", $batch
		), $start);
	}

	protected function rebuildById($id)
	{
		/**
		 *
		 * @var \FS\DeleteQuotedPosts\Service\DeleteQuotedPosts\DeleteQuotedPostService $service
		 */
		$service = \XF::service('FS\DeleteQuotedPosts:DeleteQuotedPosts\DeleteQuotedPostService');
		$service->deleteFirstQuotedPostsOfThreadId($id);
	}

	protected function getStatusType()
	{
		return \XF::phrase('fs_delete_first_quoted_posts');
	}
}