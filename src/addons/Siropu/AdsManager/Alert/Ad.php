<?php

namespace Siropu\AdsManager\Alert;

use XF\Mvc\Entity\Entity;

class Ad extends \XF\Alert\AbstractHandler
{
     public function getEntityWith()
     {
          return ['Extra'];
     }
     public function canViewContent(Entity $entity, &$error = null)
	{
          return true;
     }
}
