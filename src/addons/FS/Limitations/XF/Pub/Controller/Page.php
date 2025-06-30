<?php

namespace FS\Limitations\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Page extends XFCP_Page
{
	public function actionIndex(ParameterBag $params)
	{		
		$parent =  parent::actionIndex($params);

		$users = $this->app->finder('XF:User')->where('is_featured', 1)->fetch(20);

		if(count($users) > 0){
		$parent->setParam('users', $users);
		}
		
		return $parent;
	}
}