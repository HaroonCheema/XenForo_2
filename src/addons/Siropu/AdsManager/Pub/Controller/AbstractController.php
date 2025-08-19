<?php

namespace Siropu\AdsManager\Pub\Controller;

use XF\Mvc\Reply\View;
use XF\Mvc\ParameterBag;

abstract class AbstractController extends \XF\Pub\Controller\AbstractController
{
     public static function getActivityDetails(array $activities)
	{
		return \XF::phrase('siropu_ads_manager_viewing_ads_manager');
	}
     protected function assertCanCreateAds()
     {
          if (!\XF::visitor()->canCreateAdsSiropuAdsManager())
          {
               throw $this->exception($this->noPermission());
          }
     }
     protected function assertAdvertiserPackage($packageId)
     {
          $package = $this->assertPackageExists($packageId);

          if (!$package->isValidAdvertiser())
          {
               throw $this->exception($this->noPermission());
          }

          return $package;
     }
     /**
      * @return \Siropu\AdsManager\Entity\Ad
      */
     protected function assertAdExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:Ad', $id, $with, 'siropu_ads_manager_requested_ad_not_found');
     }
     /**
      * @return \Siropu\AdsManager\Entity\Package
      */
     protected function assertPackageExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:Package', $id, $with, 'siropu_ads_manager_requested_package_not_found');
     }
     /**
      * @return \Siropu\AdsManager\Entity\Invoice
      */
     protected function assertInvoiceExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:Invoice', $id, $with, 'siropu_ads_manager_requested_invoice_not_found');
     }
     /**
      * @return \Siropu\AdsManager\Repository\Ad
      */
     public function getAdRepo()
     {
          return $this->repository('Siropu\AdsManager:Ad');
     }
     /**
      * @return \Siropu\AdsManager\Repository\Package
      */
     public function getPackageRepo()
     {
          return $this->repository('Siropu\AdsManager:Package');
     }
     /**
      * @return \Siropu\AdsManager\Repository\Invoice
      */
     public function getInvoiceRepo()
     {
          return $this->repository('Siropu\AdsManager:Invoice');
     }
     /**
      * @return \Siropu\AdsManager\Repository\PromoCode
      */
     public function getPromoCodeRepo()
     {
          return $this->repository('Siropu\AdsManager:PromoCode');
     }
     /**
      * @return \Siropu\AdsManager\Repository\DailyStats
      */
     public function getDailyStatsRepo()
     {
          return $this->repository('Siropu\AdsManager:DailyStats');
     }
     /**
      * @return \Siropu\AdsManager\Repository\ClickStats
      */
     public function getClickStatsRepo()
     {
          return $this->repository('Siropu\AdsManager:ClickStats');
     }
     /**
      * @return \Siropu\AdsManager\Repository\Position
      */
     public function getPositionRepo()
     {
          return $this->repository('Siropu\AdsManager:Position');
     }
     /**
      * @return \Siropu\AdsManager\Repository\ClickFraud
      */
     public function getClickFraudRepo()
     {
          return $this->repository('Siropu\AdsManager:ClickFraud');
     }
     /**
	 * @return \XF\Repository\Payment
	 */
     public function getPaymentRepo()
     {
          return $this->repository('XF:Payment');
     }
     protected function addWrapperParams(View $view, $selected)
	{
		$view->setParam('pageSelected', $selected);
		return $view;
	}
}
