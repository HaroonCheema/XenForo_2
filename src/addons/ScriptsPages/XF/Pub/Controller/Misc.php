<?php

declare(strict_types=1);

namespace ScriptsPages\XF\Pub\Controller;

use ScriptsPages\{
    Setup,
    XF\Mvc\Reply\Raw
};

use XF\Pub\Controller\MiscController;

/**
 * @mixin MiscController
 */
class Misc extends XFCP_Misc
{
	function actionScriptPage()
    {
		if (!Setup::get('init'))
			return $this->noPermission();

		if (Setup::get('navigation_id'))
			$this->setSectionContext(Setup::get('navigation_id'));

	   return new Raw(Setup::get('content'));
	}
}