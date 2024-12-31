<?php

namespace OzzModz\Badges\Cli\Command\Rebuild;

class BadgeAwardedNumber extends \XF\Cli\Command\Rebuild\AbstractRebuildCommand
{
	/**
	 * @inheritDoc
	 */
	protected function getRebuildName()
	{
		return 'ozzmodz-badges-badge-awarded-number';
	}

	protected function getRebuildDescription()
	{
		return 'Rebuild awarded users badge counts';
	}

	protected function getRebuildClass()
	{
		return '\OzzModz\Badges:BadgeAwardedNumberRebuild';
	}
}