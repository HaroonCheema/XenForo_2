<?php

namespace Siropu\AdsManager\Alert;

use XF\Mvc\Entity\Entity;

class Invoice extends \XF\Alert\AbstractHandler
{
     public function getEntityWith()
     {
          return ['Ad'];
     }
     public function canViewContent(Entity $entity, &$error = null)
	{
          return true;
     }
}
