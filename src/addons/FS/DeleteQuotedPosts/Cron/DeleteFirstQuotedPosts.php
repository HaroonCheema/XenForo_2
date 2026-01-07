<?php

namespace FS\DeleteQuotedPosts\Cron;

/**
 * Cron entry
 */
class DeleteFirstQuotedPosts
{
	/**
	 * Runs the cron-based check
	 */
	public static function deleteFirstQuotedPosts()
	{
		// \XF::app()->jobManager()
		// ->enqueueUnique(
		// 	'fsDeleteQuotedFirstPosts', 
		// 	'FS\DeleteQuotedPosts:DeleteQuotedPosts', 
		// 	[], 
		// 	false
		// );
		\XF::app()->jobManager()
		->enqueue(
			'FS\DeleteQuotedPosts:DeleteQuotedPosts', 
			[]
		);
	}
}
