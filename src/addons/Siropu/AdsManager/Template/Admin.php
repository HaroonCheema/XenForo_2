<?php

namespace Siropu\AdsManager\Template;

class Admin
{
     public function isGeoLite2CityDb()
     {
          return file_exists(\XF::getAddOnDirectory() . '/Siropu/AdsManager/Vendor/MaxMind/GeoLite2-City.mmdb');
     }
     public function hasZipArhive()
     {
          return class_exists('ZipArchive');
     }
     public function getRevenew()
     {
          return $this->getInvoiceRepo()->getRevenewPerCurrency();
     }
     public function getPendingAds()
     {
          return $this->getAdRepo()
               ->findAdsForList()
               ->ofStatus('pending')
               ->order('create_date', 'DESC')
               ->fetch();
     }
     public function getPositionData()
     {
          return $this->getPositionRepo()->getPositionListData();
     }
     public function getAdSizes()
	{
          $customSizes = \XF::options()->siropuAdsManagerAdCustomSizes;
          $sizeList    = [];

          if (!empty($customSizes))
          {
               foreach ($customSizes as $size)
               {
                    $sizeList[] = "{$size['width']}x{$size['height']}";
               }
          }

		return [
			[
				'group' => \XF::phrase('siropu_ads_manager_unit_size.custom'),
				'sizes' => $sizeList
			],
			[
				'group' => \XF::phrase('siropu_ads_manager_unit_size.horizontal'),
				'sizes' => ['970x90', '728x90', '468x60', '320x100', '320x50']
			],
			[
				'group' => \XF::phrase('siropu_ads_manager_unit_size.vertical'),
				'sizes'    => ['300x600', '160x600', '120x600']
			],
			[
				'group' => \XF::phrase('siropu_ads_manager_unit_size.rectangular'),
				'sizes' => ['336x280', '300x250', '250x250', '200x200']
			]
		];
	}
     public function getStatuses()
     {
          return [
               'active'         => \XF::phrase('siropu_ads_manager_status.active'),
               'inactive'       => \XF::phrase('siropu_ads_manager_status.inactive'),
               'pending'        => \XF::phrase('siropu_ads_manager_status.pending'),
               'approved'       => \XF::phrase('siropu_ads_manager_status.approved'),
               'queued'         => \XF::phrase('siropu_ads_manager_status.queued'),
               'queued_invoice' => \XF::phrase('siropu_ads_manager_status.queued_invoice'),
               'paused'         => \XF::phrase('siropu_ads_manager_status.paused'),
               'archived'       => \XF::phrase('siropu_ads_manager_status.archived'),
               'rejected'       => \XF::phrase('siropu_ads_manager_status.rejected')
          ];
     }
     public function getPromoThreadForums()
     {
          return \XF::finder('XF:Node')
               ->where('node_id', \XF::options()->siropuAdsManagerPromoThreadForums)
               ->order('title', 'ASC')
               ->fetch()
               ->pluckNamed('title', 'node_id');
     }
     public function getUserGroupTitlePairs()
     {
          return \XF::repository('XF:UserGroup')->getUserGroupTitlePairs();
     }
     /**
      * @return \Siropu\AdsManager\Repository\Ad
      */
     public function getAdRepo()
     {
          return \XF::repository('Siropu\AdsManager:Ad');
     }
     /**
      * @return \Siropu\AdsManager\Repository\Position
      */
     public function getPositionRepo()
     {
          return \XF::repository('Siropu\AdsManager:Position');
     }
     /**
      * @return \Siropu\AdsManager\Repository\Invoice
      */
     public function getInvoiceRepo()
     {
          return \XF::repository('Siropu\AdsManager:Invoice');
     }
}
