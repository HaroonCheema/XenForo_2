<?php

namespace Siropu\ReferralSystem\Cron;

class CleanUp
{
     public static function runDailyCleanUp()
	{
          $unconfirmedReferrals = \XF::finder('XF:User')
               ->where('siropu_rs_referrer_id', '<>', 0)
               ->where('user_state', 'email_confirm')
               ->where('register_date', '>=', \XF::$time - 86400)
               ->fetch();

          foreach ($unconfirmedReferrals as $referral)
          {
               $referrer = $referral->SRS_Referrer;

               if ($referrer)
               {
                    $referrer->fastUpdate('siropu_rs_referral_count', max(0, $referrer->siropu_rs_referral_count - 1));
               }

               $referral->fastUpdate('siropu_rs_referrer_id', 0);
          }
     }
}
