<?php

namespace Siropu\ReferralSystem\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class RewardType extends Repository
{
     public function findRewardTypesForList()
     {
          return $this->finder('Siropu\ReferralSystem:RewardType');
     }
}
