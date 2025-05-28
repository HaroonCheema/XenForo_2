<?php

namespace Siropu\ReferralSystem\Admin\Controller;

use XF\Mvc\ParameterBag;

abstract class AbstractController extends \XF\Admin\Controller\AbstractController
{
     protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('siropuReferralSystem');
	}
}
