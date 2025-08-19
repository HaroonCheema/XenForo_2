<?php

namespace Siropu\AdsManager\Pub\Controller;

use XF\Mvc\ParameterBag;

class Package extends AbstractController
{
     protected function preDispatchController($action, ParameterBag $params)
     {
          $this->assertCanCreateAds();
     }
     public function actionIndex(ParameterBag $params)
     {
          $type = $this->filter('type', 'str');

          if (!$type)
          {
               $this->getAdRepo()->processQueue();
          }

          $finder = $this->getPackageRepo()
               ->findPackagesForList()
               ->notOfType('affiliate')
               ->order('display_order', 'ASC')
               ->order('title', 'ASC');

          if ($type)
          {
               $finder->ofType($type);
          }

          $packages = $finder->fetch()->filter(function(\Siropu\AdsManager\Entity\Package $package)
          {
               return ($package->isValidAdvertiser());
          });

          $types = $this->getPackageRepo()
               ->findPackagesForList()
               ->fetch()
               ->filter(function(\Siropu\AdsManager\Entity\Package $package)
               {
                    return ($package->isValidAdvertiser());
               });

          $viewParams = [
               'packages' => $packages,
               'types'    => $types->pluckNamed('type', 'type'),
               'type'     => $type
          ];

          $view = $this->view('Siropu\AdsManager:Package\List', 'siropu_ads_manager_package_list', $viewParams);
          return $this->addWrapperParams($view, 'packages');
     }
     public function actionDiscounts(ParameterBag $params)
     {
          $package = $this->assertAdvertiserPackage($params->package_id);

          $viewParams = [
               'package' => $package
          ];

          return $this->view('Siropu\AdsManager:Package\Discounts', 'siropu_ads_manager_package_discounts', $viewParams);
     }
     public function actionCreateAd(ParameterBag $params)
     {
          $package = $this->assertAdvertiserPackage($params->package_id);

          if (!$this->isLoggedIn())
          {
               return $this->noPermission();
          }

          if ($package->empty_slot_count)
          {
               $this->getAdRepo()->processQueue();
          }

          if ($package->isPurchaseLimitReached())
          {
               return $this->noPermission(\XF::phrase('siropu_ads_manager_advertiser_ad_limit_reached', [
                    'limit' => $package->advertiser_purchase_limit
               ]));
          }

          return $this->rerouteController('Siropu\AdsManager:Ad', 'add', ['Package' => $package]);
     }
}
