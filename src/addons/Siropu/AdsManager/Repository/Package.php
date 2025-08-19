<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Package extends Repository
{
     public function findPackagesForList()
     {
          return $this->finder('Siropu\AdsManager:Package');
     }
     public function getDefaultPackage()
     {
          $package = $this->em->create('Siropu\AdsManager:Package');
          $package->setTrusted('package_id', 0);
          $package->setTrusted('title', \XF::phrase('siropu_ads_manager_no_package'));
          $package->setReadOnly(true);

          return $package;
     }
     public function findPackagesForAdList()
     {
          $packages = $this->findPackagesForList()->fetch();

          $defaultPackage = $this->getDefaultPackage();
		$packages = $packages->toArray();
		$packages = $packages + [$defaultPackage];
		$packages = $this->em->getBasicCollection($packages);

          return $packages;
     }
     public function getPackageTitlePairs()
     {
          $packages = $this->finder('Siropu\AdsManager:Package')->order('title');
          return $packages->fetch()->pluckNamed('title', 'package_id');
     }
     public function getPackagesForSelect()
     {
          return $this->findPackagesForList()
               ->fetch()
               ->pluckNamed('title', 'package_id');
     }
     public function getTypePackagesForSelect($type)
     {
          return $this->findPackagesForList()
               ->ofType($type)
               ->fetch()
               ->pluckNamed('title', 'package_id');
     }
     public function inheritPackage($packageId, $force = false)
     {
          $finder = $this->repository('Siropu\AdsManager:Ad')->findAdsForPackage($packageId);

          if (!$force)
          {
               $finder->where('inherit_package', 1);
          }

          foreach ($finder->fetch() as $ad)
          {
               $ad->inheritPackage($ad->Extra->purchase != 0);
               $ad->save();
          }
     }
     public function updateAdvertiseHereThreadCache()
     {
          $packages = $this->findPackagesForList()
               ->ofType(['thread', 'sticky'])
               ->where('advertise_here', 1)
               ->fetch()
               ->filter(function(\Siropu\AdsManager\Entity\Package $package)
               {
                    return ($package->cost_amount > 0 && !empty($package->advertiser_criteria));
               });

          $simpleCache = $this->app()->simpleCache();
          $simpleCache['Siropu/AdsManager']['advertiseHerePackageIds'] = $packages->pluckNamed('package_id');
     }
     public function getAdCount($packageId, $status = null)
     {
          $finder = $this->repository('Siropu\AdsManager:Ad')->findAdsForPackage($packageId);

          if ($status)
          {
               $finder->ofStatus($status);
          }

          return $finder->total();
     }
     public function updateAdCount($packageId)
     {
          $this->db()->update(
               'xf_siropu_ads_manager_package',
               ['ad_count' => $this->getAdCount($packageId)],
               'package_id = ?', $packageId
          );
     }
     public function getActiveAdCount($packageId)
     {
          return $this->db()->fetchOne('
               SELECT COUNT(*)
               FROM xf_siropu_ads_manager_ad AS a
               LEFT JOIN xf_siropu_ads_manager_ad_extra AS e ON a.ad_id = e.ad_id
               WHERE (a.status IN ("active", "approved", "paused") OR e.prev_status IN ("active", "approved", "paused"))
               AND e.is_placeholder = 0
               AND e.count_exclude = 0
               AND a.package_id = ?
          ', $packageId);
     }
     public function updateEmptySlotCount($packageId)
     {
          if (!$packageId)
          {
               return;
          }

          $package = $this->em->find('Siropu\AdsManager:Package', $packageId);

          if (!$package)
          {
               return;
          }

          $itemCount = 1;

          if ($package->isThread())
          {
               $itemCount = @count(\XF::options()->siropuAdsManagerPromoThreadForums);
          }

          if ($package->isSticky())
          {
               $itemCount = @count(\XF::options()->siropuAdsManagerAllowedStickyForums);
          }

          if ($package->isResource())
          {
               $itemCount = @count(\XF::options()->siropuAdsManagerAllowedFeaturedResourceCategories);
          }

          $emptySlotCount = ($package->ad_allowed_limit * $itemCount) - $this->getActiveAdCount($packageId);

          $this->db()->update(
               'xf_siropu_ads_manager_package',
               ['empty_slot_count' => max(0, $emptySlotCount)],
               'package_id = ?', $packageId
          );
     }
     public function getPakageAdStats($packageId)
     {
          return $this->db()->fetchRow('
               SELECT
                    COALESCE(SUM(view_count), 0) AS total_views,
                    COALESCE(SUM(click_count), 0) AS total_clicks,
                    COALESCE(ROUND(AVG(ctr), 2), 0) AS avg_ctr,
                    COALESCE(COUNT(*), 0) AS total_ads
               FROM xf_siropu_ads_manager_ad
               WHERE type NOT IN ("sticky", "resource")
               AND package_id = ?
          ', $packageId);
     }
     public function getTopPerformingPackages($orderField, $orderDir)
	{
          if (!in_array($orderField, ['title', 'total_views', 'total_clicks']))
          {
               $orderField = 'avg_ctr';
          }

          if (!in_array($orderDir, ['desc', 'asc']))
          {
               $orderDir = 'desc';
          }

		return $this->db()->fetchAll('
			SELECT p.*,
                    COALESCE((
                         SELECT SUM(view_count)
                         FROM xf_siropu_ads_manager_ad AS a
                         WHERE a.package_id = p.package_id
                    ), 0) AS total_views,
                    COALESCE((
                         SELECT SUM(click_count)
                         FROM xf_siropu_ads_manager_ad AS a
                         WHERE a.package_id = p.package_id
                    ), 0) AS total_clicks,
				COALESCE((
					SELECT ROUND(AVG(a.ctr), 2)
					FROM xf_siropu_ads_manager_ad AS a
					WHERE a.package_id = p.package_id
				), 0) AS avg_ctr
			FROM xf_siropu_ads_manager_package AS p
               WHERE p.type NOT IN ("sticky", "resource")
               AND p.ad_count > 0
			ORDER BY ' . $orderField . ' ' . $orderDir . '
			LIMIT 10
		');
	}
     public function sortAds($ads)
     {
          $embedList      = [];
          $placeholders   = [];
          $priorityValues = [];

          foreach ($ads as $ad)
          {
               $embedList[$ad->type][$ad->package_id][$ad->ad_id] = $ad;

               if ($ad->Package)
               {
                    $placeholders[$ad->package_id] = $ad->Package->placeholder_id;
                    $priorityValues[$ad->package_id][$ad->ad_id] = $ad->display_priority;
               }
          }

          foreach ($embedList as $type => &$packageAds)
          {
               foreach ($packageAds as $packageId => &$adList)
               {
                    if ($packageId && count($adList) > 1)
                    {
                         $placeholderId = $placeholders[$packageId];

                         if ($placeholderId)
                         {
                              unset($adList[$placeholderId], $priorityValues[$packageId][$placeholderId]);
                         }

                         $firstAd      = current($adList);
                         $displayLimit = $firstAd->Package->ad_display_limit;
                         $displayOrder = $firstAd->Package->ad_display_order;

                         if ($displayOrder == 'random')
                         {
                              if (array_sum($priorityValues[$packageId]) > 0)
                              {
                                   foreach ($priorityValues[$packageId] as $adId => $priority)
                                   {
                                        $priorityValues[$packageId][$adId] = $priority ?: 1;
                                   }

                                   $this->sortAdsByPriority($adList, $packageId, $priorityValues);
                              }
                              else
                              {
                                   shuffle($adList);
                              }
                         }
                         else
                         {
                              usort($adList, '\Siropu\AdsManager\Util\Package::sortAdsByPackageOrder');
                         }

                         if (count($adList) > $displayLimit)
                         {
                              $adList = array_slice($adList, 0, $displayLimit);
                         }
                    }
               }

               unset($adList);
          }

          unset($packageAds);

          return $embedList;
     }
     protected function sortAdsByPriority(&$adList, $packageId, &$priorityValues)
     {
          $adCount      = count($adList);
          $adListSorted = [];

          for ($i = 0; $i < $adCount; $i++)
          {
               $id = \Siropu\AdsManager\Util\Package::getRandomWeightedElement($priorityValues[$packageId]);
               $adListSorted[] = $adList[$id];

               unset($priorityValues[$packageId][$id]);
          }

          $adList = $adListSorted;
     }
     public function getColumns()
     {
          return $this->em->getEntityStructure('Siropu\AdsManager:Package')->columns;
     }
}
