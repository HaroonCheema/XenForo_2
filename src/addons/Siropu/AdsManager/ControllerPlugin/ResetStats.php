<?php

namespace Siropu\AdsManager\ControllerPlugin;

class ResetStats extends \XF\ControllerPlugin\AbstractPlugin
{
     public function resetAdStats(\Siropu\AdsManager\Entity\Ad $ad, $type = 'general')
     {
          if ($this->isPost())
          {
               switch ($type)
               {
                    case 'general':
                         $this->getAdRepo()->resetGeneralStats($ad->ad_id);
                         break;
                    case 'daily':
                         $this->getAdRepo()->resetDailyStats($ad->ad_id);
                         break;
                    case 'click':
                         $this->getAdRepo()->resetClickStats($ad->ad_id);
                         break;
                    default:
                         $this->getAdRepo()->resetAllStats($ad->ad_id);
                         return $this->redirect($this->buildLink('ads-manager/ads'));
                         break;
               }

               return $this->redirect($this->buildLink("ads-manager/ads/{$type}-stats", $ad));
          }

          $viewParams = [
               'ad'   => $ad,
               'type' => $type
          ];

          return $this->view('Siropu\AdsManager:ResetStats', 'siropu_ads_manager_ad_reset_stats', $viewParams);
     }
     /**
      * @return \Siropu\AdsManager\Repository\Ad
      */
     public function getAdRepo()
     {
          return $this->repository('Siropu\AdsManager:Ad');
     }
}
