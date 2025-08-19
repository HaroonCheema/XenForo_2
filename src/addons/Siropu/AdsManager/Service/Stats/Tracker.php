<?php

namespace Siropu\AdsManager\Service\Stats;

class Tracker extends \XF\Service\AbstractService
{
	protected $ad;

	protected $views = [];
	protected $clicks = [];

	public function __construct(\XF\App $app, \Siropu\AdsManager\Entity\Ad $ad)
	{
		parent::__construct($app);

		$this->ad     = $ad;
		$this->views  = (array) json_decode($this->app->request()->getCookie('sam_ad_views'), true);
		$this->clicks = (array) json_decode($this->app->request()->getCookie('sam_ad_clicks'), true);
	}
	public function trackView()
	{
		$this->views[$this->ad->ad_id] = \XF::$time;
		$this->app->response()->setCookie('sam_ad_views', json_encode($this->views));
	}
	public function trackClick()
	{
		$this->clicks[$this->ad->ad_id] = \XF::$time;
		$this->app->response()->setCookie('sam_ad_clicks', json_encode($this->clicks));
	}
	public function getViewDate()
	{
		if (isset($this->views[$this->ad->ad_id]))
		{
			return (int) $this->views[$this->ad->ad_id];
		}
	}
	public function getClickDate()
	{
		if (isset($this->clicks[$this->ad->ad_id]))
		{
			return (int) $this->clicks[$this->ad->ad_id];
		}
	}
	public function isViewed()
	{
          $visitor = \XF::visitor();
          $options = \XF::options();

          if ($this->ad->Package && $this->ad->Package->isCpm() && $this->ad->user_id == $visitor->user_id && !$visitor->is_admin)
          {
               return true;
          }

		$viewDate = $this->getViewDate();
		return $viewDate && $viewDate >= \XF::$time - $options->siropuAdsManagerViewCountCondition * 3600;
	}
	public function isClicked()
	{
		$clickDate = $this->getClickDate();
		return $clickDate && $clickDate >= \XF::$time - \XF::options()->siropuAdsManagerClickCountCondition * 3600;
	}
}
