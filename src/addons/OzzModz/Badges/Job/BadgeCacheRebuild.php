<?php


namespace OzzModz\Badges\Job;


use OzzModz\Badges\Addon;

class BadgeCacheRebuild extends \XF\Job\AbstractJob
{
	public function run($maxRunTime)
	{
		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = $this->app->repository(Addon::shortName('Badge'));
		$badgeRepo->rebuildBadgesCache();

		return $this->complete();
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('rebuilding');
		$typePhrase = \XF::phrase('core_caches');
		return sprintf('%s... %s', $actionPhrase, $typePhrase);
	}

	public function canCancel()
	{
		return true;
	}

	public function canTriggerByChoice()
	{
		return false;
	}
}