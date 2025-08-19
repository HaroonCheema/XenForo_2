<?php

namespace Siropu\AdsManager\Pub\Controller;

use XF\Mvc\ParameterBag;

class Statistics extends \XF\Pub\Controller\AbstractController
{
     public function actionIndex(ParameterBag $params)
     {
          $statsAccess = $this->assertStatsAccessExists($params->access_key);

          $ads = $this->getAdRepo()
               ->findAdsForList()
               ->where('ad_id', $statsAccess->ad_list)
               ->fetch();

          $viewParams = [
               'statsAccess' => $statsAccess,
               'ads'         => $ads
          ];

          return $this->view('Siropu\AdsManager:Statistics', 'siropu_ads_manager_statistics', $viewParams);
     }
     public function actionDaily(ParameterBag $params)
     {
          $statsAccess = $this->assertStatsAccessExists($params->access_key);
          $ad = $this->assertAdExists($this->filter('ad_id', 'uint'));

          $plugin = $this->plugin('Siropu\AdsManager:DailyStats');
          return $plugin->getDailyStatsForAd($ad, false, $params->access_key);
     }
     public function actionClick(ParameterBag $params)
     {
          $statsAccess = $this->assertStatsAccessExists($params->access_key);
          $ad = $this->assertAdExists($this->filter('ad_id', 'uint'));

          $plugin = $this->plugin('Siropu\AdsManager:ClickStats');
          return $plugin->getClickStatsForAd($ad, $params->access_key);
     }
     /**
      * @return \Siropu\AdsManager\Repository\Ad
      */
     public function getAdRepo()
     {
          return $this->repository('Siropu\AdsManager:Ad');
     }
     /**
      * @return \Siropu\AdsManager\Entity\StatsAccess
      */
     protected function assertStatsAccessExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:StatsAccess', $id, $with);
     }
     /**
      * @return \Siropu\AdsManager\Entity\Ad
      */
     protected function assertAdExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:Ad', $id, $with);
     }
}
