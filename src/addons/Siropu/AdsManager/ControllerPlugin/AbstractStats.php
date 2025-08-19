<?php

namespace Siropu\AdsManager\ControllerPlugin;

class AbstractStats extends \XF\ControllerPlugin\AbstractPlugin
{
	protected $startDate;
	protected $endDate;
	protected $datePreset;
	protected $positionId;
	protected $grouping;
	protected $page = 1;
	protected $perPage = 20;

	public function __construct(\XF\Mvc\Controller $controller)
	{
		parent::__construct($controller);

		$this->startDate  = $controller->filter('start', 'datetime');
		$this->endDate    = $controller->filter('end', 'datetime');
		$this->datePreset = $controller->filter('date_preset', 'datetime');
		$this->positionId = $controller->filter('position_id', 'str');
		$this->grouping   = $controller->filter('grouping', 'str');
		$this->page       = $controller->filterPage();
	}
}
