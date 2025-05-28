<?php

namespace Siropu\ReferralSystem\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Referrer extends Repository
{
     public function getTopReferrers($limit = 10)
     {
          return $this->db()->fetchAll('
               SELECT u2.*, COUNT(*) AS siropu_rs_referral_count
               FROM xf_user AS u1
               LEFT JOIN xf_user AS u2 ON u2.user_id = u1.siropu_rs_referrer_id
               WHERE u1.siropu_rs_referrer_id <> 0
               AND u1.register_date >= ?
               AND u1.user_state = "valid"
               AND u1.is_banned = 0
               AND u2.is_banned = 0
               GROUP BY u1.siropu_rs_referrer_id
               ORDER BY siropu_rs_referral_count DESC
               LIMIT ?
		', [strtotime('first day of this month 00:00'), $limit]);
     }
     public function getTopReferrersFromCache()
     {
          $simpleCache = $this->app()->simpleCache();
          return $simpleCache['Siropu/ReferralSystem']['topReferrers'];
     }
     public function updateTopReferrersCache($widgetKey, array $referrers = [])
     {
          $simpleCache = $this->app()->simpleCache();
          $simpleCache['Siropu/ReferralSystem']['topReferrers'] = [$widgetKey => $referrers];
     }
     public function deleteTopReferrersCache()
     {
          $simpleCache = $this->app()->simpleCache();
          $simpleCache['Siropu/ReferralSystem']['topReferrers'] = '';
     }
     public function getValidReferrer()
	{
          $options = \XF::options();

          $referrerId = $this->app()->request()->getCookie('referrer_id');
          $referrerId = $referrerId ?: $this->app()->request()->filter($options->siropuReferralSystemReferralUrlParameter, 'str');

          if ($referrerId && $options->siropuReferralSystemEncryptUserId)
          {
               $referrerId = $this->getHashId($referrerId, false);
          }
          else if ($options->siropuReferralSystemProfilePageAsReferralLink)
          {
               $router = $this->app()->router()->routeToController($this->app()->request()->getRoutePath());

               if ($router->getController() == 'XF:Member'
                    && !empty($router->getParams()['user_id'])
                    && !$this->app()->request()->getFromSearch())
               {
                    $referrerId = $router->getParams()['user_id'];
               }
          }

          if ($referrerId)
          {
               $referrer = $this->app()->em()->find('XF:User', (int) $referrerId);

               if ($referrer && ($referrer->hasPermission('siropuReferralSystem', 'refer')))
               {
                    return $referrer;
               }
          }
	 }
      public function getHashId($id, $encode = true)
      {
           $hashids = new \Siropu\ReferralSystem\Vendor\Hashids\Hashids('T2FkHILKLr');
           return $encode ? @$hashids->encode($id) : @$hashids->decode($id)[0];
      }
      public function creditReferrerIfValidReferral(\XF\Entity\User $referrer, \XF\Entity\User $referral, $updateReferralCount = false)
      {
           if ($referral->siropu_rs_referrer_credit)
           {
                return;
           }

           $rewardType = $referrer->getReferralRegistrationReward();

           if ($rewardType)
           {
                $minimumPosts = \XF::options()->siropuReferralSystemRewardMinPosts;
                $applyReward  = true;

                if ($minimumPosts && $minimumPosts > $referral->message_count)
                {
                     $applyReward = false;
                }

                if ($applyReward)
                {
                     switch ($rewardType->type)
                     {
                          case 'trophy_points':
                              $rewardType->applyTrophyPoints($referrer);
                              break;
                          case 'dbtech_credits':
                              $rewardType->applyDbTechCredits($referrer);
                              break;
                    }

                    $this->db()->update('xf_user', ['siropu_rs_referrer_credit' => 1], 'user_id = ?', $referral->user_id);
                }
           }

           if ($updateReferralCount)
           {
                $referrer->updateReferralCountAndNotify($referral);
           }
     }
}
