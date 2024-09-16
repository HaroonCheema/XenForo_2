<?php
namespace Brivium\AdvancedThreadRating\Service\Rating;

use XF\Entity\Thread;
use XF\Service\AbstractService;

class DeleteRating extends AbstractService
{

	public function deleteRatingByThread(Thread $thread, $reason = '')
	{
		$filters = [
			'thread_id' => $thread->thread_id
		];

		$jobManager = $this->app->jobManager();
		$id = $jobManager->enqueueUnique('BRATR_postDeleteThread', 'Brivium\AdvancedThreadRating:DeleteRating', ['filters' => $filters], true);
		$jobManager->runById($id, \XF::config('jobMaxRunTime'));

		$this->app->logger()->logModeratorAction('thread', $thread, 'reset_rating', ['reason' => $reason]);
	}
}