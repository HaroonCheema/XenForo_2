<?php

namespace nick97\TraktTV\Cron;

class TvChanges
{
	public static function run()
	{
		$app = \XF::app();
		$options = \XF::options();

		if ($options->TvThreads_trackChanges) {
			$app->jobManager()->enqueueUnique(
				'snogTvThreadChanges',
				'nick97\TraktTV:TvThreadChanges',
				[],
				false
			);
		}

		if ($options->TvThreads_trackChangesAiringToday) {
			$app->jobManager()->enqueueUnique(
				'snogTvThreadChangesAiringToday',
				'nick97\TraktTV:TvThreadChangesAiringToday',
				[],
				false
			);
		}

		if ($options->TvThreads_trackCommunityChanges) {
			$app->jobManager()->enqueueUnique(
				'snogTvCommunityChanges',
				'nick97\TraktTV:TvCommunityChangesApply',
				[],
				false
			);
		}
	}
}
