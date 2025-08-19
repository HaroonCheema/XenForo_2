<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class ClickStats extends Repository
{
     public function findClickStatsForAd($adId)
     {
          return $this->finder('Siropu\AdsManager:ClickStats')
               ->where('ad_id', $adId)
               ->order('stats_date', 'DESC');
     }
     public function getVisitorData()
     {
          $visitor = \XF::visitor();
          $deviceCriteria = $this->app()->criteria('Siropu\AdsManager:Device', $visitor->toArray());

          $params  = [
               'user_id'  => 0,
               'username' => \XF::phrase('guest')->render(),
               'device'   => $deviceCriteria->getDeviceType()
          ];

          if ($visitor->user_id)
          {
               $params['user_id']  = $visitor->user_id;
               $params['username'] = $visitor->username;
          }

          return $params;
     }
     public function getClickStatsPositions($adId)
     {
          return $this->db()->fetchAll('
               SELECT p.position_id, p.title
               FROM xf_siropu_ads_manager_stats_click AS s
               LEFT JOIN xf_siropu_ads_manager_position AS p
               ON p.position_id = s.position_id
               WHERE ad_id = ?
               GROUP BY position_id
          ', $adId);
     }
     public function deleteOlderEntries()
     {
          $daysOld = \XF::options()->siropuAdsManagerDeleteClickStats;

          if ($daysOld)
          {
               $this->db()->delete('xf_siropu_ads_manager_stats_click', 'stats_date <= ?', \XF::$time - $daysOld * 86400);

               $this->optimizeTableIfNeeded();
          }
     }
     public function deleteAdStats($adId)
     {
          $this->db()->delete('xf_siropu_ads_manager_stats_click', 'ad_id IN (' . $this->db()->quote($adId) . ')');

          $this->optimizeTableIfNeeded();
     }
     public function optimizeTableIfNeeded()
     {
          $analyze = $this->db()->query('ANALYZE TABLE xf_siropu_ads_manager_stats_click')->fetch();

          if ($analyze['Msg_text'] != 'OK')
          {
               $this->db()->query('OPTIMIZE TABLE xf_siropu_ads_manager_stats_click')->fetch();
          }
     }
}
