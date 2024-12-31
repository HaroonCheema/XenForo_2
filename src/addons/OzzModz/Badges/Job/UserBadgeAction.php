<?php

namespace OzzModz\Badges\Job;

class UserBadgeAction extends \XF\Job\AbstractJob
{
	protected $defaultData = [
		'start' => 0,
		'count' => 0,
		'total' => null,
		'userBadgeIds' => null,
		'action' => ''
	];

	public function run($maxRunTime)
	{
		$startTime = microtime(true);
		$em = $this->app->em();

		$ids = $this->data['userBadgeIds'];
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

			/** @var \OzzModz\Badges\Entity\UserBadge $userBadge */
			$userBadge = $em->find('OzzModz\Badges:UserBadge', $id);
			if ($userBadge)
			{
				$this->doAction($userBadge);
			}

			if ($limitTime && microtime(true) - $startTime > $maxRunTime)
			{
				break;
			}
		}

		if (is_array($this->data['userBadgeIds']))
		{
			$this->data['userBadgeIds'] = $ids;
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

	protected function doAction(\OzzModz\Badges\Entity\UserBadge $userBadge)
	{
		if ($this->getActionValue('delete'))
		{
			$userBadge->delete(false, false);
			return;
		}

		if ($this->getActionValue('unfeature') && $userBadge->featured)
		{
			$userBadge->featured = false;
		}
		elseif ($this->getActionValue('feature') && !$userBadge->featured)
		{
			$userBadge->featured = true;
		}

		$userBadge->saveIfChanged($saved, false, false);
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('updating');
		$typePhrase = \XF::phrase('ozzmodz_badges_user_badge');

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