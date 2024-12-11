<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

class Attachment extends \XF\Pub\Controller\AbstractController
{
	public function actionIndex(ParameterBag $params)
	{
		$attachment = $this->em()->find('XF:Attachment', $params->attachment_id);

		if (!$attachment)
		{
			throw $this->exception($this->notFound());
		}

		return $this->plugin('XF:Attachment')->displayAttachment($attachment);
	}
	public function updateSessionActivity($action, ParameterBag $params, AbstractReply &$reply) {}
}
