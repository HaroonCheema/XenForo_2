<?php

namespace Siropu\AdsManager\XF\Entity;

class User extends XFCP_User
{
     public function canViewAdsSiropuAdsManager()
     {
          return $this->hasPermission('siropuAdsManager', 'viewAds') && $this->hasOptInViewAdsSiropuAdsManager();
     }
     public function canCreateAdsSiropuAdsManager()
	{
          return $this->hasPermission('siropuAdsManager', 'createAds');
     }
     public function canBypassApprovalSiropuAdsManager()
	{
          return $this->hasPermission('siropuAdsManager', 'bypassApproval');
     }
     public function canEditWithoutApprovalSiropuAdsManager()
	{
          return $this->hasPermission('siropuAdsManager', 'editWithoutApproval');
     }
     public function canViewGeneralStatsSiropuAdsManager()
	{
          return $this->hasPermission('siropuAdsManager', 'viewGeneralStats');
     }
     public function canViewDailyStatsSiropuAdsManager()
	{
          return $this->hasPermission('siropuAdsManager', 'viewDailyStats');
     }
     public function canViewClickStatsSiropuAdsManager()
	{
          return $this->hasPermission('siropuAdsManager', 'viewClickStats');
     }
     public function canUploadAttachmentsSiropuAdsManager()
	{
          return $this->hasPermission('siropuAdsManager', 'uploadAttachments');
     }
     public function canViewStatsSiropuAdsManager()
     {
          return $this->canViewGeneralStatsSiropuAdsManager()
               || $this->canViewDailyStatsSiropuAdsManager()
               || $this->canViewClickStatsSiropuAdsManager();
     }
     public function canPauseAdsSiropuAdsManager()
	{
          return $this->hasPermission('siropuAdsManager', 'pauseAds');
     }
     public function canUseDeviceCriteriaSiropuAdsManager()
     {
          return $this->hasPermission('siropuAdsManager', 'useDeviceCriteria');
     }
     public function canUseGeoCriteriaSiropuAdsManager()
     {
          return $this->hasPermission('siropuAdsManager', 'useGeoCriteria');
     }
     public function canUseMultipleBannersSiropuAdsManager()
     {
          return $this->hasPermission('siropuAdsManager', 'useMultipleBanners');
     }
     public function canUseExternalBannersSiropuAdsManager()
     {
          return $this->hasPermission('siropuAdsManager', 'useExternalBanners');
     }
     public function canUseCustomBannerCodeSiropuAdsManager()
     {
          return $this->hasPermission('siropuAdsManager', 'useCustomBannerCode');
     }
     public function canOptInViewAdsSiropuAdsManager()
     {
          return $this->hasPermission('siropuAdsManager', 'optInViewAds');
     }
     public function hasOptInViewAdsSiropuAdsManager()
     {
          if (!$this->canOptInViewAdsSiropuAdsManager())
          {
               return true;
          }

          return $this->Option->siropu_ads_manager_view_ads;
     }
}
