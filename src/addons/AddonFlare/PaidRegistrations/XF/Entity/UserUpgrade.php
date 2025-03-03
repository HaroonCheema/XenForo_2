<?php

namespace AddonFlare\PaidRegistrations\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use XF\Payment\AbstractProvider;
use AddonFlare\PaidRegistrations\Listener;

class UserUpgrade extends XFCP_UserUpgrade
{

    public function canExtendUpgrade()
    {
        $can = false;

        $visitor = \XF::visitor();

        // this feature is not necessary for recurring upgrades since they auto renew
        // disable for "permanent/lifetime" upgrades
        if ($can && !$this->recurring && $this->length_unit && $this->Active && ($active = $this->Active[$visitor->user_id]))
        {
            return $this->app()->options()->af_pr_upgrade_extend;
        }

        return false;
    }

    public function getAccountType()
    {
        return $this->repository('AddonFlare\PaidRegistrations:AccountType')->fetchAccountTypeForUserUpgrade($this);
    }

    public function getAccountTypeId()
    {
        if ($accountType = $this->AccountType)
        {
            return $accountType->account_type_id;
        }

        return null;
    }

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->getters['AccountType'] = true;
        $structure->getters['account_type_id'] = true;

        $structure->options['is_extend'] = false;

        return $structure;
    }
}