<?php

namespace OzzModz\Badges\Cli\Command\Rebuild;

class UserBadge extends \XF\Cli\Command\Rebuild\AbstractRebuildCommand
{
	/**
	 * @inheritDoc
	 */
	protected function getRebuildName()
	{
		return 'ozzmodz-badges-user-badge';
	}

	protected function getRebuildDescription()
	{
		return 'Rebuild user badges (rewards or revokes by user criteria)';
	}

	protected function getRebuildClass()
	{
		return '\OzzModz\Badges:UserBadgeRebuild';
	}
}