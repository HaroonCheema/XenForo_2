<?php

namespace OzzModz\Badges\XF;

class CssRenderer extends XFCP_CssRenderer
{
	protected function getRenderParams()
	{
		$params = parent::getRenderParams();

		if ($this->includeExtraParams)
		{
			try
			{
				$params['ozzmodzBadgesBadgeTiers'] = $this->app->container('ozzmodz_badges.tiers');
			}
			catch (\Exception $e)
			{
				$params['ozzmodzBadgesBadgeTiers'] = [];
			}
		}

		return $params;
	}
}