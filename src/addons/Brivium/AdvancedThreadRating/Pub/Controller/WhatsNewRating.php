<?php
namespace Brivium\AdvancedThreadRating\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractWhatsNewFindType;

class WhatsNewRating extends AbstractWhatsNewFindType
{

	protected function getContentType()
	{
		return 'brivium_thread_rating';
	}
}