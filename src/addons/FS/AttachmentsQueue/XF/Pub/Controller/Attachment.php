<?php

namespace FS\AttachmentsQueue\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class Attachment extends XFCP_Attachment
{
	public function actionIndex(ParameterBag $params)
	{
		$this->assertRegistrationRequired();

		return parent::actionIndex($params);
	}
}
