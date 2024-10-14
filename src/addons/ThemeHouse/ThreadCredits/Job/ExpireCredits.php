<?php

namespace ThemeHouse\ThreadCredits\Job;

use ThemeHouse\ThreadCredits\Entity\UserCreditPackage;
use XF\Job\AbstractRebuildJob;

class ExpireCredits extends AbstractRebuildJob
{
    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        return $db->fetchAllColumn($db->limit(
            "
				SELECT user_credit_package_id
				FROM xf_thtc_user_credit_package
				WHERE
				  expires_at BETWEEN 1 AND ?
				  AND credit_package_id > ?
				  AND remaining_credits > 0
				ORDER BY user_credit_package_id
			", $batch
        ), [\XF::$time, $start]);
    }

    protected function rebuildById($id)
    {
        /** @var UserCreditPackage $userCreditPackage */
        $userCreditPackage = \XF::em()->find('ThemeHouse\ThreadCredits:UserCreditPackage', $id);
        $userCreditPackage->expire();
    }

    public function getStatusMessage()
    {
        return \XF::phrase('thtc_expiring_credit_purchases...');
    }

    protected function getStatusType()
    {
    }
}