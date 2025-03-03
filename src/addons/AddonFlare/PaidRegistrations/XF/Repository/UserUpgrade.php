<?php

namespace AddonFlare\PaidRegistrations\XF\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class UserUpgrade extends XFCP_UserUpgrade
{
    public function findUserUpgradesForList()
    {
        $finder = parent::findUserUpgradesForList();

        return $finder->with('PaidRegistrationsAccountType');
    }
}