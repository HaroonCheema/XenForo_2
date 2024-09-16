<?php
namespace Brivium\AdvancedThreadRating\Job;

use Brivium\AdvancedThreadRating\Repository\Rating;
use XF\Job\AbstractJob;

class ThreadRating extends AbstractJob
{
	protected $defaultData = [
		'rebuild' => [
			'Threads' => true,
			'Receivers' => true,
			'Givers' => true
		]
	];

	public function run($maxRunTime)
	{
		$start = microtime(true);

		if(empty($this->data['rebuild']) || !is_array($this->data['rebuild']))
		{
			return $this->complete();
		}
		$rebuild = array_filter($this->data['rebuild']);
		if(empty($rebuild))
		{
			return $this->complete();
		}

		/* @var Rating $ratingRepo*/
		$ratingRepo = $this->app->repository('Brivium\AdvancedThreadRating:Rating');
		
		foreach($rebuild as $key => $val)
		{
			switch($key)
			{
				case 'Threads':
					$ratingRepo->rebuildThreads(); break;
				case 'Receivers':
					$ratingRepo->rebuildReceivers(); break;
				case 'Givers':
					$ratingRepo->rebuildGivers(); break;
			}
			$rebuild[$key] = false;
			$this->data['rebuild'] = $rebuild[$key];

			if (microtime(true) - $start >= $maxRunTime)
			{
				break;
			}
		}

		return $this->resume();
	}

	public function getStatusMessage()
	{
		$typePhrase = '';
		if(!empty($this->data['rebuild'])  && !is_array($this->data['rebuild']))
		{
			$rebuild = array_filter($this->data['rebuild']);
		}
		if(!empty($rebuild))
		{
			$typePhrase = reset(array_keys($rebuild));
		}
		$actionPhrase = \XF::phrase('BRATR_rebuild_thread_ratings');
		return sprintf('%s... %s', $actionPhrase, $typePhrase);
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