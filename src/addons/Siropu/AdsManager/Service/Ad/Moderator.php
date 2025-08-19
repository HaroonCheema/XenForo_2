<?php

namespace Siropu\AdsManager\Service\Ad;

class Moderator extends \XF\Service\AbstractService
{
	protected $isAd = false;
	protected $titles = [];

	public function __construct(\XF\App $app, $id)
	{
		parent::__construct($app);

		$ads = $this->repository('Siropu\AdsManager:Ad')
			->findAdsForList()
               ->where('item_id', $id)
			->ofStatus(['active', 'paused'])
               ->fetch();

		if ($ads->count())
		{
			foreach ($ads as $ad)
	          {
	               if ($ad->isSticky() && $ad->Thread && $ad->Thread->user_id != \XF::visitor()->user_id)
	               {
	                    $this->titles[] = $ad->Thread->title;
	               }
	               else if ($ad->isResource() && $ad->Resource && $ad->Resource->user_id != \XF::visitor()->user_id)
	               {
	                    $this->titles[] = $ad->Resource->title;
	               }
	          }

			if ($this->titles)
			{
				$this->isAd = true;
			}
		}
	}
	public function isAd()
	{
		return $this->isAd == true;
	}
	public function hasPermission($permission)
	{
		return \XF::visitor()->hasPermission('siropuAdsManager', $permission);
	}
	public function getTitles()
	{
		return implode(', ', $this->titles);
	}
}
