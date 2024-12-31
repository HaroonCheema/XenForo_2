<?php

namespace OzzModz\Badges\XF\Searcher;

use XF\Mvc\Entity\Finder;

class User extends XFCP_User
{
	protected function applySpecialCriteriaValue(Finder $finder, $key, $value, $column, $format, $relation)
	{
		if ($key == 'ozzmodz_badges_badge_ids' && !empty($value))
		{
			if (!is_array($value))
			{
				$badgeIds = [$value];
			}
			else
			{
				$badgeIds = $value;
			}

			if (in_array(0, $badgeIds))
			{
				return true;
			}

			$parts = [];
			$columnName = $finder->columnSqlName('ozzmodz_badges_received_badge_ids');
			foreach ($badgeIds as $badgeId)
			{
				$parts[] = 'FIND_IN_SET(' . $finder->quote($badgeId) . ', ' . $columnName . ')';
			}

			$finder->whereSql(implode(' AND ', $parts));

			return true;
		}

		return parent::applySpecialCriteriaValue($finder, $key, $value, $column, $format, $relation);
	}

	protected function validateSpecialCriteriaValue($key, &$value, $column, $format, $relation)
	{
		if ($key == 'ozzmodz_badges_badge_ids')
		{
			return true;
		}

		return parent::validateSpecialCriteriaValue($key, $value, $column, $format, $relation);
	}

	public function getFormData()
	{
		$data = parent::getFormData();

		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = \XF::repository('OzzModz\Badges:Badge');
		$data['ozzModzBadges'] = $badgeRepo->getBadgesOptionsData(false);

		return $data;
	}

	public function getFormDefaults()
	{
		$defaults = parent::getFormDefaults();

		$defaults['ozzmodz_badges_badge_count'] = ['end' => -1];

		return $defaults;
	}
}
