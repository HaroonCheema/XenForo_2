<?php

namespace Siropu\AdsManager\ControllerPlugin;

class ClickStats extends AbstractStats
{
     public function getClickStatsForAd(\Siropu\AdsManager\Entity\Ad $ad, $accessKey = false)
     {
          $finder = $this->getClickStatsRepo()
               ->findClickStatsForAd($ad->ad_id)
               ->with('Position')
               ->limitByPage($this->page, $this->perPage);

          $linkParams = [];

          if ($this->datePreset)
          {
               $finder->sinceDate($this->datePreset);
               $linkParams['date_preset'] = $this->datePreset;
          }
          else
          {
               if ($this->startDate)
               {
                    $finder->sinceDate($this->startDate);
                    $linkParams['start'] = $this->startDate;
               }

               if ($this->endDate)
               {
                    $finder->untilDate($this->datePreset);
                    $linkParams['end'] = $this->endDate;
               }
          }

          if ($this->positionId)
          {
               $finder->forPosition($this->positionId);
               $linkParams['position_id'] = $this->positionId;
          }

          if ($accessKey)
          {
               $linkParams['ad_id'] = $ad->ad_id;
          }

          $viewParams = [
               'ad'          => $ad,
               'clickStats'  => $finder->fetch(),
               'total'       => $finder->total(),
               'datePresets' => \XF::language()->getDatePresets(),
               'positions'   => $this->getClickStatsRepo()->getClickStatsPositions($ad->ad_id),
               'page'        => $this->page,
               'perPage'     => $this->perPage,
               'linkParams'  => $linkParams,
               'accessKey'   => $accessKey
          ];

          return $this->view('Siropu\AdsManager:Ad\ClickStats', 'siropu_ads_manager_ad_click_stats', $viewParams);
     }
     /**
      * @return \Siropu\AdsManager\Repository\ClickStats
      */
     public function getClickStatsRepo()
     {
          return $this->repository('Siropu\AdsManager:ClickStats');
     }
}
