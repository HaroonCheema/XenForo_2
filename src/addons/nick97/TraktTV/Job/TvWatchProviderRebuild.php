<?php

namespace nick97\TraktTV\Job;

class TvWatchProviderRebuild extends \XF\Job\AbstractRebuildJob
{
	protected function getNextIds($start, $batch)
	{
		$db = $this->app->db();

		return $db->fetchAllColumn($db->limit(
			"
				SELECT thread_id
				FROM nick97_trakt_tv_thread
				WHERE thread_id > ?
				ORDER BY thread_id
			",
			$batch
		), $start);
	}

	protected function rebuildById($id)
	{
		/** @var \nick97\TraktTV\Entity\TV $tv */
		$tv = $this->app->em()->find('nick97\TraktTV:TV', $id);
		if ($tv) {
			/** @var \nick97\TraktTV\Helper\Trakt\Api $apiHelper */
			$apiHelper = \XF::helper('nick97\TraktTV:Trakt\Api');
			$tmdbClient = $apiHelper->getClient();

			$apiResponse = $tmdbClient->getTv($tv->tv_id)->getWatchProviders();
			if ($tmdbClient->hasError()) {
				return;
			}

			$tv->tmdb_watch_providers = $apiResponse['results'] ?? [];
			$tv->saveIfChanged();
		}
	}

	protected function getStatusType()
	{
		return \XF::phrase('snog_tv_rebuild_watch_providers');
	}
}
