<?php

namespace Siropu\AdsManager\Pub\Controller;

use XF\Mvc\ParameterBag;

class Advertiser extends AbstractController
{
     protected function preDispatchController($action, ParameterBag $params)
     {
          if (!\XF::options()->siropuAdsManagerAdvertisersPage['enabled'])
		{
			throw $this->exception($this->noPermission());
		}
     }
     public function actionIndex(ParameterBag $params)
     {
          $ads = $this->getAdRepo()
               ->findAdsForList()
               ->embeddable()
               ->active()
               ->whereOr([['Extra.purchase', '<>', 0], ['Extra.advertiser_list', 1]])
               ->fetch()
               ->groupBy('type');

          $viewParams = [
               'ads' => $ads
          ];

          return $this->view('Siropu\AdsManager:Advertisers', 'siropu_ads_manager_advertisers', $viewParams);
     }
}
