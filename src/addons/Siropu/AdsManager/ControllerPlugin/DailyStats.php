<?php

namespace Siropu\AdsManager\ControllerPlugin;

class DailyStats extends AbstractStats
{
	public function getDailyStatsForAd(\Siropu\AdsManager\Entity\Ad $ad, $groupByPosition = true, $accessKey = false)
	{
          $linkParams = [];

          if ($this->datePreset)
          {
               $linkParams['date_preset'] = $this->datePreset;
          }
		else
		{
			if ($this->startDate)
	          {
	               $linkParams['start'] = $this->startDate;
	          }

			if ($this->endDate)
	          {
				$linkParams['end'] = $this->endDate;
			}
		}

          if ($this->positionId)
          {
               $linkParams['position_id'] = $this->positionId;
          }

		if ($this->grouping)
		{
			$linkParams['grouping'] = $this->grouping;
		}

		$conditions = array_merge([
			'ad_id'    => $ad->ad_id,
			'grouping' => 'daily'
		], $linkParams);

          if ($accessKey)
          {
               $linkParams['ad_id'] = $ad->ad_id;
          }

          if ($groupByPosition)
          {
               $conditions['groupByPos'] = true;
          }

          $viewParams = [
               'ad'          => $ad,
               'dailyStats'  => $this->getDailyStatsRepo()->getDailyStats($conditions, $this->perPage, $this->page),
               'total'       => $this->getDailyStatsRepo()->getDailyStatsCount($conditions),
               'datePresets' => \XF::language()->getDatePresets(),
			'positions'   => $this->getDailyStatsRepo()->getDailyStatsPositions($ad->ad_id),
               'page'        => $this->page,
               'perPage'     => $this->perPage,
               'linkParams'  => $linkParams,
               'accessKey'   => $accessKey
          ];

          return $this->view('Siropu\AdsManager:Ad\DailyStats', 'siropu_ads_manager_ad_daily_stats', $viewParams);
	}
	/**
      * @return \Siropu\AdsManager\Repository\PromoCode
      */
     public function getDailyStatsRepo()
     {
          return $this->repository('Siropu\AdsManager:DailyStats');
     }
}
