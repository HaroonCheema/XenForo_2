<?php

namespace OzzModz\Badges\Cli\Command\Rebuild;

class BadgeCount extends \XF\Cli\Command\Rebuild\AbstractRebuildCommand
{
	/**
	 * @inheritDoc
	 */
	protected function getRebuildName()
	{
		return 'ozzmodz-badges-user-badge-count';
	}

	protected function getRebuildDescription()
	{
		return 'Rebuild user\'s badge counts';
	}

	protected function getRebuildClass()
	{
		return '\OzzModz\Badges:UserBadgeCountRebuild';
	}
}