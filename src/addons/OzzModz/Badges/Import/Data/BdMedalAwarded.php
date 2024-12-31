<?php


namespace OzzModz\Badges\Import\Data;


use OzzModz\Badges\Addon;

class BdMedalAwarded extends \XF\Import\Data\AbstractEmulatedData
{
	public function getImportType()
	{
		return 'user_badge';
	}

	protected function getEntityShortName()
	{
		return Addon::shortName('UserBadge');
	}
}