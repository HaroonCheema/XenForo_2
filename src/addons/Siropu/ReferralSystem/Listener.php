<?php

namespace Siropu\ReferralSystem;

use XF\Mvc\Entity\Entity;

class Listener
{
	public static function appPubComplete(\XF\App $app, \XF\Http\Response &$response)
     {
          $options = \XF::options();
          $visitor = \XF::visitor();

          $referrerRepo = self::getReferrerRepo();

		if (!($visitor->user_id || $app->request()->isXhr()) && ($referrer = $referrerRepo->getValidReferrer()))
		{
               $toolId = $app->request()->filter('tool_id', 'uint');

               if ($toolId && !$app->request()->getCookie('referrer_id'))
               {
                    $tool = $app->em()->find('Siropu\ReferralSystem:Tool', $toolId);

                    if ($tool)
                    {
                         $tool->countClick();
                    }
               }

               $referrerUserId = $referrer->user_id;

               if ($options->siropuReferralSystemEncryptUserId)
               {
                    $referrerUserId = $referrerRepo->getHashId($referrerUserId);
               }

               $response->setCookie('referrer_id',  $referrerUserId);

               self::getReferrerLogRepo()->logHttpReferrer($referrer->user_id);
		}
	}
	public static function templaterSetup(\XF\Container $container, \XF\Template\Templater &$templater)
     {
		$templater->addFunction('siropu_rs_referral_link', function(
			\XF\Template\Templater $templater, &$escape, $type = 'user', \Siropu\ReferralSystem\Entity\Tool $tool = null, $pageLink = false)
		{
			$options = \XF::options();
			$visitor = \XF::visitor();
			$userId  = $visitor->user_id;

			if (!$userId)
			{
				return false;
			}

			$referralUrlParameter = $options->siropuReferralSystemReferralUrlParameter;

               if ($options->siropuReferralSystemEncryptUserId)
               {
                    $userId = self::getReferrerRepo()->getHashId($userId);
               }

			$linkParams = [
				$referralUrlParameter => $userId
			];

			$toolParams = [];

			if ($tool)
			{
				$toolParams['tool_id'] = $tool->tool_id;
			}

			$linkParams     += $toolParams;

			$requestUri      = \XF::app()->request()->getFullRequestUri();
			$userReferralUrl = \XF::app()->router()->buildLink('canonical:index', '', $linkParams);
			$pageReferralUrl = self::geneateCustomReferralUrl($requestUri, $linkParams);

			if ($options->siropuReferralSystemProfilePageAsReferralLink)
			{
				$userReferralUrl = \XF::app()->router()->buildLink('canonical:members', $visitor, $toolParams);
			}

			switch ($type)
			{
				case 'user':
					return $userReferralUrl;
					break;
				case 'page':
					return $pageReferralUrl != $userReferralUrl && $pageLink ? $pageReferralUrl : '';
					break;
				case 'tool':
					return $tool->target_url ? self::geneateCustomReferralUrl($tool->target_url, $linkParams) : $userReferralUrl;
					break;
			}
		});

          $templater->addFunction('siropu_rs_referral_link_param', function(\XF\Template\Templater $templater, &$escape)
		{
               $options = \XF::options();
               $visitor = \XF::visitor();

               if ($visitor->user_id && $options->siropuReferralSystemApplyRefLinkToSocialMedia)
               {
                    $userId = $visitor->user_id;

                    if ($options->siropuReferralSystemEncryptUserId)
                    {
                         $userId = self::getReferrerRepo()->getHashId($visitor->user_id);
                    }

                    $referralUrlParameter = "{$options->siropuReferralSystemReferralUrlParameter}={$userId}";

                    $requestUri = \XF::app()->request()->getFullRequestUri();

                    return (strpos($requestUri, '?') !== false ? '&' : '?') . $referralUrlParameter;
               }
          });

		$templater->addFunction('siropu_rs_referral_message', function(\XF\Template\Templater $templater, &$escape)
		{
               $escape = false;

			if (!(\XF::options()->siropuReferralSystemGuestMessage && \XF::visitor()->user_id == 0))
			{
				return;
			}

			$params = [];

               if ($referrer = self::getReferrerRepo()->getValidReferrer())
			{
				$params['user'] = $referrer;
			}

			if (!empty($params))
			{
				return $templater->renderTemplate('public:siropu_referral_system_guest_message', $params);
			}
		});
	}
     public static function userUpgradeActivePostSave(\XF\Mvc\Entity\Entity $entity)
	{
          if ($entity->isInsert() && ($referrer = $entity->User->SRS_Referrer))
          {
               $rewardType = $referrer->getReferralUpgradeReward();

               if ($rewardType)
               {
                    switch ($rewardType->type)
                    {
                         case 'trophy_points':
                             $rewardType->applyTrophyPoints($referrer, 'siropu_rs_referral_upg_reward');
                             break;
                         case 'dbtech_credits':
                             $rewardType->applyDbTechCredits($referrer, 'siropu_referral_system_reward_for_referral_upgrade');
                             break;
                   }
               }
          }
     }
	public static function userMergeCombine(\XF\Entity\User $target, \XF\Entity\User $source, \XF\Service\User\Merge $mergeService)
	{
		 $target->siropu_rs_referral_count += $source->siropu_rs_referral_count;

           if ($target->siropu_rs_referrer_id == 0 && $source->siropu_rs_referrer_id)
           {
                $target->siropu_rs_referrer_id = $source->siropu_rs_referrer_id;
                $target->siropu_rs_referrer_credit = $source->siropu_rs_referrer_credit;
           }
	 }
	 public static function userSearcherOrders(\XF\Searcher\User $userSearcher, array &$sortOrders)
	 {
		 $sortOrders = array_replace($sortOrders, [
			 'siropu_rs_referral_count' => \XF::phrase('siropu_referral_sytem_referral_count')
		 ]);
	 }
      public static function criteriaUser($rule, array $data, \XF\Entity\User $user, &$returnValue)
      {
		switch ($rule)
		{
               case 'siropu_rs_is_referral':
                    if (isset($user->siropu_rs_referrer_id) && $user->siropu_rs_referrer_id != 0)
                    {
                         $returnValue = true;
                    }
                    break;
			case 'siropu_rs_referral_count':
				if (isset($user->siropu_rs_referral_count) && $user->siropu_rs_referral_count >= $data['referrals'])
				{
					$returnValue = true;
				}
				break;
		}
     }
	 protected static function geneateCustomReferralUrl($url, array $params)
	 {
		 $parts = '';
		 $delim = strpos($url, '?') === false ? '?' : '&';
		 $i     = 0;

		 foreach ($params as $key => $val)
		 {
		      $i++;

		      $parts .= ($i == 1 ? $delim : '&') . "$key=$val";
		 }

		 return $url . $parts;
	}
     public static function getReferrerLogRepo()
     {
          return \XF::repository('Siropu\ReferralSystem:ReferrerLog');
     }
     public static function getReferrerRepo()
     {
          return \XF::repository('Siropu\ReferralSystem:Referrer');
     }
}
