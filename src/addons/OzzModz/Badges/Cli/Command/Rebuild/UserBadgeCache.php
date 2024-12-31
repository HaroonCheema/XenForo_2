<?php

namespace OzzModz\Badges\Cli\Command\Rebuild;

class UserBadgeCache extends \XF\Cli\Command\Rebuild\AbstractRebuildCommand
{
	/**
	 * @inheritDoc
	 */
	protected function getRebuildName()
	{
		return 'ozzmodz-badges-user-badge-cache';
	}

	protected function getRebuildDescription()
	{
		return 'Rebuild user badge caches (that used to display in common places)';
	}

	protected function getRebuildClass()
	{
		return '\OzzModz\Badges:UserBadgeCacheRebuild';
	}
}