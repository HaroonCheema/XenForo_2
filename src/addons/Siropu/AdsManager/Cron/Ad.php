<?php

namespace Siropu\AdsManager\Cron;

class Ad
{
	public static function enableAds()
	{
		$ads = self::getAdRepo()
			->findAdsForList()
			->ofStatus(['inactive', 'paused'])
			->where('start_date', '<>', 0)
			->where('start_date', '<=', \XF::$time)
			->fetch();

		foreach ($ads as $ad)
		{
			$ad->start_date = 0;
			$ad->status = 'active';

			if ($ad->isPaused())
			{
				$ad->updateEndDate();
			}

			$ad->save();
		}
     }
	public static function disableExpiredAds()
	{
		$ads = self::getAdRepo()
			->findAdsForList()
			->ofStatus('active')
			->hasExpired()
			->fetch();

		foreach ($ads as $ad)
		{
			$ad->end_date = 0;
			$ad->status = 'inactive';
               $ad->updateExtraData(['notice_sent' => 0]);
               $ad->setOption('process_queue', true);
			$ad->save();

			$notifier = \XF::service('Siropu\AdsManager:Ad\Notifier', $ad, 'expired');
			$notifier->sendNotification();
		}
     }
	public static function processQueue()
	{
		self::getAdRepo()->processQueue();
	}
	public static function disableLowCtrAds()
	{
		$disableLowCtrAds = \XF::options()->siropuAdsManagerDisableLowCtrAds;

		if ($disableLowCtrAds['enabled'])
		{
			$ads = self::getAdRepo()
				->findAdsForList()
				->ofStatus('active')
				->notOfType(['thread', 'sticky', 'featured'])
				->where('view_count', '>', 0)
				->where('ctr', '<', $disableLowCtrAds['ctr'])
				->where('Extra.active_since', '<=', strtotime("-{$disableLowCtrAds['days']} Days"))
				->where('Extra.purchase', 0)
				->fetch();

			foreach ($ads as $ad)
			{
				$ad->status = 'inactive';
				$ad->save();
			}
		}
	}
	public static function archiveInactiveAds()
	{
		$archiveTimeFrame = \XF::options()->siropuAdsManagerArchiveInactiveAds;

		if ($archiveTimeFrame)
		{
			$ads = self::getAdRepo()
				->findAdsForList()
				->ofStatus('inactive')
				->where('Extra.last_active', '<=', strtotime("-{$archiveTimeFrame} Days"))
				->fetch();

			foreach ($ads as $ad)
			{
				$ad->status = 'archived';
				$ad->save();
			}
		}
	}
     public static function dailyImpressionDistribution()
     {
          $ads = self::getAdRepo()
			->findAdsForList()
			->ofStatus('active')
               ->where('package_id', '<>', 0)
               ->where('Package.cost_per', 'cpm')
			->fetch();

          foreach ($ads as $ad)
		{
               if ($dailyImpressionDistribution = $ad->getDailyImpressionDistribution())
               {
                    self::getAdRepo()->setDailyViewLimit($ad->ad_id, $dailyImpressionDistribution);
               }
          }
     }
	public static function sendExpiryNotification()
	{
		$ads = self::getAdRepo()
			->findAdsForList()
			->ofStatus('active')
			->isPurchase()
			->where('Extra.notice_sent', 0)
			->fetch();

		foreach ($ads as $ad)
		{
			if ($ad->isAboutToExpire())
			{
				$notifier = \XF::service('Siropu\AdsManager:Ad\Notifier', $ad, 'expires');
				$notifier->sendNotification();

				$ad->Extra->notice_sent = 1;
                    $ad->Extra->save();
			}
		}
	}
     public static function runDailyCleanUp()
     {
          self::getClickStatsRepo()->deleteOlderEntries();
          self::getDailyStatsRepo()->deleteOlderEntries();
          self::getClickFraudRepo()->deleteOlderEntries();
     }
     public static function rebuildWidgetsCache()
     {
          self::getAdRepo()->rebuildWidgetsCache();
     }
	/**
      * @return \Siropu\AdsManager\Repository\Ad
      */
     private static function getAdRepo()
     {
          return \XF::app()->repository('Siropu\AdsManager:Ad');
     }
     /**
      * @return \Siropu\AdsManager\Repository\ClickStats
      */
     private static function getClickStatsRepo()
     {
          return \XF::app()->repository('Siropu\AdsManager:ClickStats');
     }
     /**
      * @return \Siropu\AdsManager\Repository\DailyStats
      */
     private static function getDailyStatsRepo()
     {
          return \XF::app()->repository('Siropu\AdsManager:DailyStats');
     }
	/**
      * @return \Siropu\AdsManager\Repository\ClickFraud
      */
     private static function getClickFraudRepo()
     {
          return \XF::app()->repository('Siropu\AdsManager:ClickFraud');
     }
}
