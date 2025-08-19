<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class AdExtra extends Repository
{
     public function getColumns()
	{
		return $this->em->getEntityStructure('Siropu\AdsManager:AdExtra')->columns;
	}
}
