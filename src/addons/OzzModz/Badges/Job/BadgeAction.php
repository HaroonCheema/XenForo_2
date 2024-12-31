<?php

namespace OzzModz\Badges\Job;

class BadgeAction extends \XF\Job\AbstractJob
{
	protected $defaultData = [
		'start' => 0,
		'count' => 0,
		'total' => null,
		'badgeIds' => null,
		'action' => ''
	];

	public function run($maxRunTime)
	{
		$startTime = microtime(true);
		$em = $this->app->em();

		$ids = $this->data['badgeIds'];
		sort($ids, SORT_NUMERIC);
		if (!$ids)
		{
			return $this->complete();
		}

		$db = $this->app->db();
		$db->beginTransaction();

		$limitTime = ($maxRunTime > 0);
		foreach ($ids as $key => $id)
		{
			$this->data['count']++;
			$this->data['start'] = $id;
			unset($ids[$key]);

			/** @var \OzzModz\Badges\Entity\Badge $badge */
			$badge = $em->find('OzzModz\Badges:Badge', $id);
			if ($badge)
			{
				$this->doAction($badge);
			}

			if ($limitTime && microtime(true) - $startTime > $maxRunTime)
			{
				break;
			}
		}

		if (is_array($this->data['badgeIds']))
		{
			$this->data['badgeIds'] = $ids;
		}

		$db->commit();

		return $this->resume();
	}

	protected function getActionValue($action)
	{
		$value = null;
		if (!empty($this->data['actions'][$action]))
		{
			$value = $this->data['actions'][$action];
		}
		return $value;
	}

	protected function doAction(\OzzModz\Badges\Entity\Badge $badge)
	{
		if ($this->getActionValue('delete'))
		{
			$badge->delete(false, false);
			return;
		}

		if ($this->getActionValue('disable') && $badge->active)
		{
			$badge->active = false;
		}
		elseif ($this->getActionValue('enable') && !$badge->active)
		{
			$badge->active = true;
		}

		$badge->saveIfChanged($saved, false, false);
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('updating');
		$typePhrase = \XF::phrase('ozzmodz_badges_badge');

		if ($this->data['total'] !== null)
		{
			return sprintf('%s... %s (%d/%d)', $actionPhrase, $typePhrase, $this->data['count'], $this->data['total']);
		}
		else
		{
			return sprintf('%s... %s (%d)', $actionPhrase, $typePhrase, $this->data['start']);
		}
	}

	public function canCancel()
	{
		return true;
	}

	public function canTriggerByChoice()
	{
		return false;
	}
}