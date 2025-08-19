<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class DailyStats extends Repository
{
     public function findDailyStatsForAd($adId)
     {
          return $this->finder('Siropu\AdsManager:DailyStats')
               ->where('ad_id', $adId)
               ->order('stats_date', 'DESC');
     }
     public function logAction(\Siropu\AdsManager\Entity\Ad $ad, $action, $position = null)
     {
          $em = $this->em->create('Siropu\AdsManager:DailyStats');
          $em->ad_id = $ad->ad_id;
          $em->position_id = $position ?: $this->app()->request()->filter('position_id', 'str');

          if (!$em->position_id)
          {
               return;
          }

          if ($action == 'view')
          {
               $em->view_count = 1;
          }
          else
          {
               $em->click_count = 1;
          }

          $this->db()->query("
               INSERT INTO xf_siropu_ads_manager_stats_daily
                    (stats_date, ad_id, position_id, view_count, click_count)
               VALUES
                    (?, ?, ?, ?, ?)
               ON DUPLICATE KEY UPDATE
                    view_count = VALUES(view_count) + view_count,
                    click_count = VALUES(click_count) + click_count
          ", $em->toArray());
     }
     public function insertBulk(array $rows)
     {
          $this->db()->insertBulk('xf_siropu_ads_manager_stats_daily', $rows, false, 'view_count = VALUES(view_count) + view_count, click_count = VALUES(click_count) + click_count');
     }
     public function getDailyStats(array $conditions, $limit = 20, $offset = 0)
     {
          $db = $this->db();

          $results = $db->fetchAll($db->limit('
               SELECT
                    *,
                    DATE_FORMAT(FROM_UNIXTIME(stats_date), "%Y") as year,
                    DATE_FORMAT(FROM_UNIXTIME(stats_date), "%b") as month,
                    DATE_FORMAT(FROM_UNIXTIME(stats_date), "%d") as day,
                    DATE_FORMAT(FROM_UNIXTIME(stats_date), "%h %p") as hour,
                    SUM(view_count) as view_count,
                    SUM(click_count) as click_count
               FROM xf_siropu_ads_manager_stats_daily
               WHERE ' . $this->prepareWhereConditions($conditions) . '
               GROUP BY ' . $this->prepareGroupByConditions($conditions) . '
               ORDER BY stats_date DESC
          ', $limit, ($offset - 1) * $limit));

          $entities = [];

          foreach ($results as $result)
          {
               switch ($conditions['grouping'])
     		{
     			case 'daily':
     				$displayDate = "{$result['month']} {$result['day']}, {$result['year']}";
                         break;
     			case 'monthly':
                         $displayDate = "{$result['month']}, {$result['year']}";
                         break;
     			default:
                         $displayDate = "{$result['month']} {$result['day']}, {$result['year']}, {$result['hour']}";
                         break;
     		}

               $entity = $this->em->instantiateEntity('Siropu\AdsManager:DailyStats', $result);
               $entity->setOption('display_date', $displayDate);

               $entities[] = $entity;
          }

          return $entities;
     }
     public function getDailyStatsCount(array $conditions)
     {
          return $this->db()->fetchOne('
               SELECT COUNT(*)
               FROM (SELECT COUNT(*)
                    FROM xf_siropu_ads_manager_stats_daily
                    WHERE ' . $this->prepareWhereConditions($conditions) . '
                    GROUP BY ' . $this->prepareGroupByConditions($conditions) . '
               ) as total'
          );
     }
     public function prepareWhereConditions($conditions)
	{
          $db = $this->db();

		$where = 'ad_id = ' . $db->quote($conditions['ad_id']);

		if (!empty($conditions['date_preset']))
		{
			$where .= ' AND stats_date >= ' . $db->quote($conditions['date_preset']);
		}
		else
		{
			if (!empty($conditions['start']))
               {
                    $where .= ' AND stats_date >= ' . $db->quote($conditions['start']);
               }
               if (!empty($conditions['end']))
               {
                    $where .= ' AND stats_date <= ' . $db->quote($conditions['end']);
               }
		}

		if (!empty($conditions['position_id']))
		{
			$where .= ' AND position_id = ' . $db->quote($conditions['position_id']);
		}

		return $where;
	}
	public function prepareGroupByConditions($conditions)
	{
          $groupByPositionId = !empty($conditions['groupByPos']) ? ', position_id' : '';

		switch ($conditions['grouping'])
		{
			case 'daily':
				return 'YEAR(FROM_UNIXTIME(stats_date)), MONTH(FROM_UNIXTIME(stats_date)), DAY(FROM_UNIXTIME(stats_date))' . $groupByPositionId;
			case 'monthly':
				return 'YEAR(FROM_UNIXTIME(stats_date)), MONTH(FROM_UNIXTIME(stats_date))' . $groupByPositionId;
			default:
				return 'YEAR(FROM_UNIXTIME(stats_date)), MONTH(FROM_UNIXTIME(stats_date)), DAY(FROM_UNIXTIME(stats_date)), HOUR(FROM_UNIXTIME(stats_date))' . $groupByPositionId;
		}
	}
     public function getDailyStatsPositions($adId)
     {
          return $this->db()->fetchAll('
               SELECT p.position_id, p.title
               FROM xf_siropu_ads_manager_stats_daily AS s
               LEFT JOIN xf_siropu_ads_manager_position AS p
               ON p.position_id = s.position_id
               WHERE ad_id = ?
               GROUP BY position_id
          ', $adId);
     }
     public function getTopPerformingPositions($orderField, $orderDir)
     {
          if (!in_array($orderField, ['p.title','total_views', 'total_clicks']))
          {
               $orderField = 'ctr';
          }

          if (!in_array($orderDir, ['desc', 'asc']))
          {
               $orderDir = 'desc';
          }

          return $this->db()->fetchAll('
               SELECT
                    p.position_id,
                    p.title,
                    SUM(view_count) AS total_views,
                    SUM(click_count) AS total_clicks,
                    ROUND(SUM(click_count) / SUM(view_count) * 100, 2) AS ctr
               FROM xf_siropu_ads_manager_stats_daily AS s
               INNER JOIN xf_siropu_ads_manager_position AS p ON p.position_id = s.position_id
               GROUP BY s.position_id
               ORDER BY ' . $orderField . ' ' . $orderDir . '
               LIMIT 10
          ');
     }
     public function deleteOlderEntries()
     {
          $daysOld = \XF::options()->siropuAdsManagerDeleteDailyStats;

          if ($daysOld)
          {
               $this->db()->delete('xf_siropu_ads_manager_stats_daily', 'stats_date <= ?', \XF::$time - $daysOld * 86400);

               $this->optimizeTableIfNeeded();
          }
     }
     public function deleteAdStats($adId)
     {
          $this->db()->delete('xf_siropu_ads_manager_stats_daily', 'ad_id IN (' . $this->db()->quote($adId) . ')');

          $this->optimizeTableIfNeeded();
     }
     public function optimizeTableIfNeeded()
     {
          $analyze = $this->db()->query('ANALYZE TABLE xf_siropu_ads_manager_stats_daily')->fetch();

          if ($analyze['Msg_text'] != 'OK')
          {
               $this->db()->query('OPTIMIZE TABLE xf_siropu_ads_manager_stats_daily')->fetch();
          }
     }
     public function getStatsDate()
     {
          $timeZone = new \DateTimeZone(\XF::options()->guestTimeZone);
          $dateTime = new \DateTime('now', $timeZone);
          $dateTime = new \DateTime($dateTime->format('Y-m-d H:00'), $timeZone);

		return $dateTime->format('U');
     }
}
