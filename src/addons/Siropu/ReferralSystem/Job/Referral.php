<?php

namespace Siropu\ReferralSystem\Job;

use XF\Job\AbstractRebuildJob;

class Referral extends AbstractRebuildJob
{
	protected function getNextIds($start, $batch)
	{
		$db = $this->app->db();

		return $db->fetchAllColumn($db->limit(
			"
				SELECT user_id
				FROM xf_user
				WHERE user_id > ?
                    ORDER BY user_id
			", $batch
		), $start);
	}
     protected function rebuildById($id)
	{
          /** @var \XF\Entity\User $user */
		$user = $this->app->em()->find('XF:User', $id);

          $referralCount = $this->app->db()->fetchOne('
               SELECT COUNT(*)
               FROM xf_user
               WHERE siropu_rs_referrer_id = ?
               AND user_state = "valid"', $user->user_id
          );

          $user->fastUpdate('siropu_rs_referral_count', $referralCount);
     }
	protected function getStatusType()
	{
		return \XF::phrase('siropu_referral_system_rebuilding_referral_count');
	}
}
