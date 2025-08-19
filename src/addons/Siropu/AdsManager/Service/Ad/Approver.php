<?php

namespace Siropu\AdsManager\Service\Ad;

class Approver extends \XF\Service\AbstractService
{
	protected $ad;
     protected $packageId;
	protected $nodeId = 0;
     protected $categoryId = 0;
     protected $userId = 0;
	protected $keywords = [];
	protected $exclusiveKeywords = [];
	protected $verifyExclusive = false;
     protected $emptySlots = true;
     protected $canUseExclusively = true;

	public function __construct(\XF\App $app, \Siropu\AdsManager\Entity\Ad $ad = null)
	{
		parent::__construct($app);

		$this->ad = $ad;
          $this->userId = \XF::visitor()->user_id;
	}
     public function setAd(\Siropu\AdsManager\Entity\Ad $ad)
     {
          $this->ad = $ad;
     }
	public function setVerifyExclusive($state)
	{
		$this->verifyExclusive = $state;
	}
	public function setKeywords($keywords)
	{
		$this->keywords = \Siropu\AdsManager\Util\Arr::getItemArray($keywords, true, "\n");
	}
     public function setPackageId($packageId)
     {
          $this->packageId = $packageId;
     }
	public function setNodeId($nodeId)
	{
		$this->nodeId = $nodeId;
	}
     public function setCategoryId($categoryId)
	{
		$this->categoryId = $categoryId;
	}
	public function verifyEmptySlots(&$error = null)
	{
		if ($this->ad->Package->empty_slot_count == 0 && !$this->ad->isActive())
		{
			$error = \XF::phraseDeferred('siropu_ads_manager_no_empty_slots');
               $this->emptySlots = false;

			return false;
		}
		else if ($this->ad->isKeyword() && $this->verifyExclusive)
		{
			return $this->verifyExclusiveKeywords($error);
		}
          else if ($this->ad->isThread())
		{
			return $this->verifyPromoThreadForumLimit($error);
		}
		else if ($this->ad->isSticky())
		{
			return $this->verifyEmptyStickySlots($error);
		}
          else if ($this->ad->isResource())
		{
			return $this->verifyEmptyFeaturedSlots($error);
		}

		return true;
	}
	public function verifyExclusiveKeywords(&$error = null)
	{
		$this->keywords = $this->keywords ?: $this->ad->getKeywords();

		foreach ($this->keywords as $keyword)
		{
			$finder = \XF::finder('Siropu\AdsManager:Ad')
				->havingContent($keyword)
				->notOfStatus(['inactive', 'rejected', 'archived'])
				->where('Extra.exclusive_use', 1);

			if ($this->ad)
			{
				$finder->where('ad_id', '<>', $this->ad->ad_id);
			}

			if ($finder->total())
			{
				$this->exclusiveKeywords[] = $keyword;
			}
		}

		if (!empty($this->exclusiveKeywords))
		{
			$error = \XF::phraseDeferred('siropu_ads_manager_exclusive_keywords_x_cannot_be_used',
				['keywords' => implode(', ', $this->exclusiveKeywords)]);

               $this->canUseExclusively = false;
			return false;
		}

		return true;
	}
     public function verifyPromoThreadForumLimit(&$error = null)
     {
          $package = $this->getPackage();

          if (!$package)
          {
               return;
          }

          if ($this->nodeId == 0)
		{
			$this->nodeId = $this->ad->content_1;
		}

          $threadCount = $this->finder('Siropu\AdsManager:Ad')
               ->where('content_1', $this->nodeId)
               ->ofType('thread')
               ->ofStatus('active')
               ->total();

          $threadLimit = $package->ad_allowed_limit;

          if ($threadCount >= $threadLimit)
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_forum_limit_reached', ['limit' => $threadLimit]);
               $this->emptySlots = false;

			return false;
          }

          return true;
     }
     public function verifyPromoThreadUserForumLimit(&$error = null)
     {
          $userThreadCount = $this->finder('Siropu\AdsManager:Ad')
               ->where('content_1', $this->nodeId)
               ->forUser($this->userId)
               ->ofType('thread')
               ->ofStatus('active')
               ->total();

          $threadUserLimit = \XF::options()->siropuAdsManagerMaxUserPromoThreads;

          if ($userThreadCount >= $threadUserLimit)
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_forum_user_promo_thread_limit_reached', ['limit' => $threadUserLimit]);
			return false;
          }

          return true;
     }
     public function verifyEmptyPromoThreadStickySlots(&$error = null)
     {
          $adCount = $this->finder('Siropu\AdsManager:Ad')
               ->where('content_1', $this->nodeId)
               ->where('Extra.is_sticky', 1)
               ->ofType('thread')
               ->ofStatus('active')
               ->total();

          $maxForumStickies = \XF::options()->siropuAdsManagerMaxPromoThreadStickies;

          if ($adCount >= $maxForumStickies)
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_forum_limit_reached', ['limit' => $maxForumStickies]);
			return false;
          }

          return true;
     }
	public function verifyEmptyStickySlots(&$error = null)
	{
		if ($this->nodeId == 0)
		{
			$thread = $this->ad->Thread;

			if ($thread)
			{
				$this->nodeId = $thread->node_id;
			}
		}

		$stickies = $this->getForumStickyThreads();

          $adCount = $this->finder('Siropu\AdsManager:Ad')
               ->where('item_id', $stickies->pluckNamed('thread_id'))
               ->ofType('sticky')
               ->active()
               ->total();

          $maxForumStickies = \XF::options()->siropuAdsManagerForumMaxStickies;

          if ($adCount >= $maxForumStickies)
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_forum_sticky_limit_reached', ['limit' => $maxForumStickies]);
               $this->emptySlots = false;

			return false;
          }

          $userStickyCount = 0;

          foreach ($stickies as $sticky)
          {
               if ($sticky->user_id == $this->userId)
               {
                    $userStickyCount++;
               }
          }

          $maxUserStickies = \XF::options()->siropuAdsManagerUserMaxStickies;

          if ($userStickyCount >= $maxUserStickies)
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_user_sticky_limit_reached', ['limit' => $maxUserStickies]);
			return false;
          }

		return true;
	}
     public function verifyEmptyFeaturedSlots(&$error = null)
     {
          $package = $this->getPackage();

          if (!$package)
          {
               return;
          }

          if ($this->categoryId == 0)
		{
			$resource = $this->ad->Resource;

			if ($resource)
			{
				$this->categoryId = $resource->resource_category_id;
			}
		}

          $featured = $this->finder('XFRM:ResourceFeature')
               ->with('Resource')
               ->fetch()
               ->filter(function(\XFRM\Entity\ResourceFeature $resourceFeature)
               {
                    return ($resourceFeature->Resource->resource_state == 'visible'
                         && $resourceFeature->Resource->resource_category_id == $this->categoryId);
               });

          $adCount = $this->finder('Siropu\AdsManager:Ad')
               ->where('item_id', $featured->pluckNamed('resource_id'))
               ->ofType('resource')
               ->active()
               ->total();

          $allowedLimit = $package->ad_allowed_limit;

          if ($adCount >= $allowedLimit)
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_resource_category_feature_limit_reached', ['limit' => $allowedLimit]);
               $this->emptySlots = false;

			return false;
          }

          return true;
     }
     public function getEmptySlots()
     {
          return $this->emptySlots;
     }
     public function getCanUseExclusively()
     {
          return $this->canUseExclusively;
     }
     public function getPackage()
     {
          return $this->ad ? $this->ad->Package : \XF::em()->find('Siropu\AdsManager:Package', $this->packageId);
     }
     protected function getForumStickyThreads()
     {
          return $this->finder('XF:Thread')
               ->where('node_id', $this->nodeId)
               ->where('discussion_state', 'visible')
               ->where('discussion_type', '<>', 'redirect')
               ->where('sticky', 1)
               ->fetch();
     }
}
