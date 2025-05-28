<?php

namespace Siropu\ReferralSystem\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Tool extends Repository
{
     public function findToolsForList()
     {
          return $this->finder('Siropu\ReferralSystem:Tool');
     }
}
