<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Ad extends Repository
{
     public function findAdsForList()
     {
          return $this->finder('Siropu\AdsManager:Ad');
     }
     public function findActiveAdsForDisplay()
     {
          return $this->findAdsForList()
               ->ofType(['code', 'banner', 'text', 'link', 'popup', 'background'])
               ->ofStatus('active')
               ->order('display_order', 'ASC');
     }
     public function findActiveFilterAds()
     {
          return $this->findAdsForList()
               ->ofType(['keyword', 'affiliate'])
               ->ofStatus('active');
     }
     public function findAdsForPackage($packageId)
     {
          return $this->findAdsForList()->forPackage($packageId);
     }
     public function findAdsForUser($userId)
     {
          return $this->findAdsForList()->forUser($userId);
     }
     public function getAdNamePairs()
     {
          $ads = $this->finder('Siropu\AdsManager:Ad')
               ->order('name', 'ASC');

          return $ads->fetch()->pluckNamed('name', 'ad_id');
     }
     public function processQueue()
     {
          $ads = $this->findAdsForList()
			->ofStatus('queued')
               ->order('create_date', 'ASC')
			->fetch();

		foreach ($ads as $ad)
		{
               if (!$ad->Package)
               {
                    continue;
               }

			if ($ad->Package->getEmptySlotCountFromDb())
			{
                    $approver = \XF::service('Siropu\AdsManager:Ad\Approver', $ad);

                    if ($ad->isThread() && !$approver->verifyPromoThreadForumLimit()
                         || $ad->isSticky() && !$approver->verifyEmptyStickySlots()
                         || $ad->isResource() && !$approver->verifyEmptyFeaturedSlots())
                    {
                         continue;
                    }

				$ad->activate();
			}
		}
     }
     public function unsetPackage($packageId)
     {
          $this->db()->update(
               'xf_siropu_ads_manager_ad',
               ['package_id' => 0, 'inherit_package' => 0],
               'package_id = ?', $packageId
          );
     }
     public function deletePackageAds($packageId)
     {
          $this->db()->delete('xf_siropu_ads_manager_ad', 'package_id = ?', $packageId);
     }
     public function getUserPairs()
     {
          return $this->db()->fetchPairs('
               SELECT a.user_id, a.username
               FROM xf_siropu_ads_manager_ad AS a
               LEFT JOIN xf_siropu_ads_manager_ad_extra AS e ON a.ad_id = e.ad_id
               GROUP by a.user_id
               ORDER BY a.username ASC
          ');
     }
     public function changeOwner(array $ads, \XF\Entity\User $user)
     {
          $db = $this->db();
          $db->update('xf_siropu_ads_manager_ad',
               ['user_id' => $user->user_id, 'username' => $user->username],
               'ad_id IN (' . $db->quote($ads) . ')'
          );

          $extraFields = [
               'purchase'           => 1,
               'email_notification' => 1,
               'alert_notification' => 1
          ];

          $db->update('xf_siropu_ads_manager_ad_extra', $extraFields, 'ad_id IN (' . $db->quote($ads) . ')');
     }
     public function setDailyViewLimit($adId, $dailyViewLimit)
     {
           $this->db()->update('xf_siropu_ads_manager_ad', ['daily_view_limit' => $dailyViewLimit], 'ad_id = ?', $adId);
     }
     public function getWidgetsCache()
     {
          $simpleCache = $this->app()->simpleCache();
          return $simpleCache['Siropu/AdsManager']['widgets'];
     }
     public function getWidgetsCacheData()
     {
          $options             = \XF::options();
          $advertisersWidget   = @$options->siropuAdsManagerAdvertisersWidget;
          $featThreadsWidget   = @$options->siropuAdsManagerFeaturedThreadsWidget;
          $featResourcesWidget = @$options->siropuAdsManagerFeaturedResourcesWidget;

          if (!($advertisersWidget || $featThreadsWidget || $featResourcesWidget))
          {
               return;
          }

          $finder = $this->finder('Siropu\AdsManager:Ad')
               ->with('Extra')
               ->active();

          if (!$advertisersWidget)
          {
               if ($featThreadsWidget)
               {
                    $finder->ofType('sticky');
               }

               if ($featResourcesWidget)
               {
                    $finder->ofType('resource');
               }
          }

          $cache = [
               'advertiserIds' => [],
               'threadIds'     => [],
               'resourceIds'   => []
          ];

          foreach ($finder->fetch() AS $ad)
          {
               if ($finder->isPurchase())
               {
                    $cache['advertiserIds'][$ad->user_id] = $ad->user_id;
               }

               switch ($ad->type)
               {
                    case 'sticky':
                    case 'thread':
                         $cache['threadIds'][] = $ad->item_id;
                         break;
                    case 'resource':
                         $cache['resourceIds'][] = $ad->item_id;
                         break;
               }
          }

          return $cache;
     }
     public function rebuildWidgetsCache()
     {
          $simpleCache = $this->app()->simpleCache();
          $simpleCache['Siropu/AdsManager']['widgets'] = $this->getWidgetsCacheData();
     }
     public function resetGeneralStats($adId)
     {
          $this->db()->update('xf_siropu_ads_manager_ad', ['view_count' => 0, 'click_count' => 0, 'ctr' => 0], 'ad_id = ?', $adId);
     }
     public function resetDailyStats($adId)
     {
          $this->db()->delete('xf_siropu_ads_manager_stats_daily', 'ad_id = ?', $adId);
     }
     public function resetClickStats($adId)
     {
          $this->db()->delete('xf_siropu_ads_manager_stats_click', 'ad_id = ?', $adId);
     }
     public function resetAllStats($adId)
     {
          $this->resetGeneralStats($adId);
          $this->resetDailyStats($adId);
          $this->resetClickStats($adId);
     }
     public function updateMailAdCache()
     {
          $ads = $this->findAdsForList()
               ->where('type', ['code', 'banner', 'text', 'link'])
               ->where('status', 'active')
               ->fetch()
               ->filter(function(\Siropu\AdsManager\Entity\Ad $ad)
               {
                    return (in_array('mail_above_content', $ad->position) || in_array('mail_below_content', $ad->position));
               });

          $simpleCache = $this->app()->simpleCache();
          $simpleCache['Siropu/AdsManager']['mailAdIds'] = $ads->pluckNamed('ad_id');
     }
     public function getColumns()
	{
		return $this->em->getEntityStructure('Siropu\AdsManager:Ad')->columns;
	}
}
