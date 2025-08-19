<?php

namespace Siropu\AdsManager\Pub\Controller;

class Embed extends AbstractController
{
     public function actionIndex()
     {
          $adId      = $this->filter('aid', 'uint');
          $packageId = $this->filter('pid', 'uint');

          $finder = $this->getAdRepo()->findActiveAdsForDisplay();

          if ($adId)
          {
               $finder->where('ad_id', $adId);
          }
          else if ($packageId)
          {
               $finder->forPackage($packageId);
          }

          $ads = $finder->fetch()->filter(function(\Siropu\AdsManager\Entity\Ad $ad)
          {
               return ($ad->canDisplay()
                    && $ad->matchesUserCriteria()
                    && $ad->matchesDeviceCriteria()
                    && $ad->matchesGeoCriteria());
          });

          $loadCarousel = 0;

          if ($ads->count())
          {
               foreach ($ads as $ad)
               {
                    if ($ad->Package && $ad->Package->isCarousel(2))
                    {
                         $loadCarousel += 1;
                    }
               }
          }

          $viewParams = [
               'ads'          => $this->getPackageRepo()->sortAds($ads),
               'loadCarousel' => $loadCarousel > 1
          ];

          return $this->view('Siropu\AdsManager:Embed', 'siropu_ads_manager_embed', $viewParams);
     }
}
