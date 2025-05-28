<?php

namespace Siropu\ReferralSystem\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
     public function actionReferrals(ParameterBag $params)
	{
          $user    = $this->assertViewableUser($params->user_id);

          $type    = $this->filter('type', 'str');
          $page    = $params->page;
		$perPage = 20;

          $finder = $this->finder('XF:User')
               ->isValidUser()
               ->where('siropu_rs_referrer_id', $user->user_id)
               ->order('register_date', 'desc');

          if ($type == 'currentMonth')
          {
               $finder->where('register_date', '>=', strtotime('first day of this month 00:00'));
          }

		$total = $finder->total();

          $this->assertValidPage($page, $perPage, $total, 'members/referrals', $user);
		$this->assertCanonicalUrl($this->buildLink('members/referrals', $user, ['page' => $page]));

          $referrals = $finder->limitByPage($page, $perPage)->fetch();

          $viewParams = [
               'user'      => $user,
               'referrals' => $referrals,
               'total'     => $total,
               'page'      => $page,
               'perPage'   => $perPage
          ];

          return $this->view('XF:Member\Referrals', 'siropu_referral_system_member_referrals', $viewParams);
     }
}
