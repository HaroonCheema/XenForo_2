<?php

namespace Siropu\ReferralSystem\Spam\Cleaner;

use XF\Spam\Cleaner\AbstractHandler;

class User extends AbstractHandler
{
	public function canCleanUp(array $options = [])
	{
		return !empty($options['siropu_referral_system']);
	}
	public function cleanUp(array &$log, &$error = null)
	{
		$actions   = \XF::app()->request()->filter('siropu_referral_system', 'array-uint');

          $user      = $this->user;
          $referrer  = $user->SRS_Referrer;
          $referrals = $user->SRS_Referrals;

          if ($referrer && !empty($actions['remove_referrer']))
          {
               \XF::db()->update('xf_user', ['siropu_rs_referrer_id' => 0], 'user_id = ?', $user->user_id);

               \XF::db()->update('xf_user',
                    ['siropu_rs_referral_count' => $referrer->siropu_rs_referral_count - 1],
                    'user_id = ?', $referrer->user_id);
          }

          if ($referrals->count() && !empty($actions['remove_referrals']))
          {
               \XF::db()->update('xf_user', ['siropu_rs_referrer_id' => 0], 'siropu_rs_referrer_id = ?', $user->user_id);
               \XF::db()->update('xf_user', ['siropu_rs_referral_count' => 0], 'user_id = ?', $user->user_id);
          }

		return true;
	}
	public function restore(array $log, &$error = null)
	{
		return true;
	}
}
