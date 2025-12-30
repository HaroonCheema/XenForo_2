<?php

declare(strict_types=1);

namespace ScriptsPages\XF\Pub\Controller;

use XF\Pub\Controller\AbstractController;

use ScriptsPages\Setup;

class Page extends AbstractController
{
	function actionIndex()
	{
		if (!Setup::get("init"))
			return $this->noPermission();

	   return $this->view("", Setup::$rawTemplate, ['content' => Setup::get("content")]);
	}
}