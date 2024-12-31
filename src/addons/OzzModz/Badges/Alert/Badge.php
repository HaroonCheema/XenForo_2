<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Alert;

use XF\Alert\AbstractHandler;
use XF\Mvc\Entity\Entity;

class Badge extends AbstractHandler
{
	public function canViewContent(Entity $entity, &$error = null)
	{
		return true;
	}

	public function getOptOutActions()
	{
		if (!\XF::options()->ozzmodz_badges_emailToggle)
		{
			return [
				'award'
			];
		}

		return [];
	}

	public function getOptOutDisplayOrder()
	{
		return 30010;
	}
}