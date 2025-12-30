<?php

declare(strict_types=1);

namespace ScriptsPages\XF\Mvc;

use ScriptsPages\Setup;
use XF\Http\Request;

/**
 * @mixin \XF\Mvc\Router
 */
class Router extends XFCP_Router {
	function routeToController($path, Request $request = null) {
		if (!Setup::get('init'))
			return parent::routeToController($path, $request);

		$match = $this->getNewRouteMatch();
		$match->setController("XF:Misc");
		$match->setAction("script-page");

		return $match;
	}
}
