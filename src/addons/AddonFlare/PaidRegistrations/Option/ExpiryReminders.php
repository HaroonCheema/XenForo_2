<?php

namespace AddonFlare\PaidRegistrations\Option;

use XF\Util\Arr;

class ExpiryReminders extends \XF\Option\AbstractOption
{
	public static function verifyOption(array &$values, \XF\Entity\Option $option)
	{
		if ($option->isInsert())
		{
			// insert - just trust the default value
			return true;
		}

		if (!empty($values['enabled']))
		{
			$days = Arr::stringToArray($values['days'], '#\s*,\s*#');

			$days = array_filter(array_map('intval', $days));

			if (!$days)
			{
				$option->error(\XF::phrase('af_pr_please_enter_at_least_one_valid_day_expiry'), $option->option_id);
				return false;
			}

			sort($days, SORT_NUMERIC);

			$values['days'] = $days;
		}
		else
		{
			$values['days'] = [];
		}

		return true;
	}
}