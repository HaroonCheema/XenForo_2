<?php
namespace Brivium\AdvancedThreadRating\Job;

use XF\Job\AbstractJob;

class DeleteRating extends AbstractJob
{
	protected $defaultData = [
		'limit' => 10,
		'offset' => 0,
		'filters' => []
	];

	public function run($maxRunTime)
	{
		$start = microtime(true);

		if(empty($this->data['filters']))
		{
			return $this->complete();
		}

		$ratings = $this->app->finder('Brivium\AdvancedThreadRating:Rating')->where($this->data['filters'])->fetch($this->data['limit'], $this->data['offset']);
		if(!$ratings->count())
		{
			return $this->complete();
		}

		foreach($ratings as $rating)
		{
			if (microtime(true) - $start >= $maxRunTime)
			{
				break;
			}
			$this->data['offset']++;
			$rating->delete(false);
		}
		return $this->resume();
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('BRATR_reset_thread_rating');
		$typePhrase = \XF::phrase('rating');
		return sprintf('%s... %s (%s)', $actionPhrase, $typePhrase, \XF::language()->numberFormat($this->data['offset']));
	}

	public function canCancel()
	{
		return true;
	}

	public function canTriggerByChoice()
	{
		return true;
	}
}