<?php

namespace FS\DeleteQuotedPosts\Job;

use XF\Job\AbstractJob;

class DeleteQuotedPosts extends AbstractJob
{
	public function run($maxRunTime)
	{
        /**
		 *
		 * @var \FS\DeleteQuotedPosts\Service\DeleteQuotedPosts\DeleteQuotedPostService $service
		 */
		$service = \XF::service('FS\DeleteQuotedPosts:DeleteQuotedPosts\DeleteQuotedPostService');
		$service->deleteFirstQuotedPosts();

		return $this->complete();
	}


	public function getStatusMessage()
	{
		return \XF::phrase('running_delete_quoted_posts_addon_job');
	}

	public function canCancel()
	{
		return false;
	}

	public function canTriggerByChoice()
	{
		return false;
	}
}