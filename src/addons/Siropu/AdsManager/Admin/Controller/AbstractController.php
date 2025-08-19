<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Util\File;

abstract class AbstractController extends \XF\Admin\Controller\AbstractController
{
     protected function preDispatchController($action, ParameterBag $params)
     {
          $this->assertAdminPermission('siropuAdsManager');
     }
     /**
      * @param string $id
      * @param array|string|null $with
      *
      * @return \Siropu\AdsManager\Entity\Ad
      */
     protected function assertAdExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:Ad', $id, $with, 'siropu_ads_manager_requested_ad_not_found');
     }
     /**
      * @param string $id
      * @param array|string|null $with
      *
      * @return \Siropu\AdsManager\Entity\Package
      */
     protected function assertPackageExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:Package', $id, $with, 'siropu_ads_manager_requested_package_not_found');
     }
     /**
      * @param string $id
      * @param array|string|null $with
      *
      * @return \Siropu\AdsManager\Entity\Invoice
      */
     protected function assertInvoiceExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:Invoice', $id, $with, 'siropu_ads_manager_requested_invoice_not_found');
     }
     /**
      * @param string $id
      * @param array|string|null $with
      *
      * @return \XF\Entity\User
      */
     protected function assertUserExists($id = null, $with = null)
     {
		return $this->assertRecordExists('XF:User', $id, $with, 'requested_user_not_found');
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
      * @return \Siropu\AdsManager\Repository\Position
      */
     public function getPositionRepo()
     {
          return $this->repository('Siropu\AdsManager:Position');
     }
     /**
      * @return \Siropu\AdsManager\Repository\PositionCategory
      */
     public function getPositionCategoryRepo()
     {
          return $this->repository('Siropu\AdsManager:PositionCategory');
     }
     /**
      * @return \Siropu\AdsManager\Repository\PromoCode
      */
     public function getPromoCodeRepo()
     {
          return $this->repository('Siropu\AdsManager:PromoCode');
     }
     /**
      * @return \Siropu\AdsManager\Repository\ClickStats
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
	 * @return \XF\Repository\Payment
	 */
     public function getPaymentRepo()
     {
          return $this->repository('XF:Payment');
     }
     public function hasZipArhive()
     {
          return class_exists('ZipArchive');
     }
     public function initExport(\XF\Mvc\Entity\Finder $finder, $serviceClass = 'Siropu\AdsManager:Ad\Export')
     {
          $this->setResponseType($this->hasZipArhive() ? 'raw' : 'xml');

          $exportService = $this->service($serviceClass);
          $xml = $exportService->export($finder);

          return $this->view($serviceClass, '', ['xml' => $xml]);
     }
     public function getBannerDir()
     {
          return \XF::options()->siropuAdsManagerBannerDirName ?: 'siropu/am/user';
     }
     protected function importFromZip($upload)
     {
          $zip = new \ZipArchive;

          if ($zip->open($upload->getTempFile()) === TRUE)
          {
               $importDir      = 'data/siropu/am/import';
               $dataFilePath   = "{$importDir}/data.xml";
               $bannerDirPath  = "{$importDir}/user";
               $packageDirPath = "{$importDir}/package";

               $dataFile = $zip->getFromName('data.xml');

     		if (!$dataFile)
     		{
                    throw new \XF\PrintableException(\XF::phrase('siropu_ads_manager_invalid_import'));
               }

               $zip->extractTo($importDir);
               $zip->close();

               $xml = \XF\Util\Xml::openFile($dataFilePath);

               $importService = $this->service('Siropu\AdsManager:Package\Import');
               $importService->import($xml);

               unlink($dataFilePath);

               if (file_exists($bannerDirPath))
               {
                    File::copyDirectory($bannerDirPath, "data/{$this->getBannerDir()}");
                    File::deleteDirectory($bannerDirPath);
               }

               if (file_exists($packageDirPath))
               {
                    File::copyDirectory($packageDirPath, 'data/siropu/am/package');
                    File::deleteDirectory($packageDirPath);
               }

               return $this->redirect($this->getDynamicRedirect());
          }
     }
     protected function getType()
     {
          return $this->filter('type', 'str') ?: 'code';
     }
}
