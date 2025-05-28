<?php

namespace Siropu\ReferralSystem\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Account extends XFCP_Account
{
     public function actionReferrals()
     {
          $visitor = \XF::visitor();

          if (!$visitor->hasPermission('siropuReferralSystem', 'refer'))
          {
               return $this->noPermission();
          }

		$page    = $this->filterPage();
		$perPage = 20;

          $finder = $this->finder('XF:User')
               ->isValidUser()
               ->where('siropu_rs_referrer_id', $visitor->user_id)
               ->order('register_date', 'desc');

		$total = $finder->total();
		$this->assertValidPage($page, $perPage, $total, 'account/referrals');

		$referrals = $finder->limitByPage($page, $perPage)->fetch();

          $viewParams = [
               'referrals' => $referrals,
               'total'     => $total,
               'page'      => $page,
               'perPage'   => $perPage
          ];

          $view = $this->view('XF:Account\Referrals', 'siropu_referral_system_account_referrals', $viewParams);
          return $this->addAccountWrapperParams($view, 'referrals');
     }
     public function actionReferralTools()
     {
          $visitor = \XF::visitor();

          if (!$visitor->hasPermission('siropuReferralSystem', 'refer'))
          {
               return $this->noPermission();
          }

          $tools = $this->getReferralToolRepo()
               ->findToolsForList()
               ->where('enabled', 1)
               ->fetch()
               ->groupBy('type');

          $viewParams = [
               'tools' => $tools
          ];

          $view = $this->view('XF:Account\ReferralTools', 'siropu_referral_system_account_referral_tools', $viewParams);
          return $this->addAccountWrapperParams($view, 'referral_tools');
     }
     public function actionReferralToolsPreview()
     {
          $tool = $this->assertReferralToolExists($this->filter('tool_id', 'uint'));

          $viewParams = [
               'tool' => $tool
          ];

          return $this->view('XF:Account\ReferralToolsPreview', 'siropu_referral_system_referral_tool_preview', $viewParams);
     }
     public function actionReferralToolsGenerate()
     {
          $options = \XF::options();
          $visitor = \XF::visitor();

          if (!$visitor->hasPermission('siropuReferralSystem', 'refer'))
          {
               return $this->noPermission();
          }

          $url = $this->filter('url', 'str');

          if (strpos($url, $options->boardUrl) === false)
          {
               return $this->message(\XF::phrase('please_enter_valid_url'));
          }

          $userId = $visitor->user_id;

          if ($options->siropuReferralSystemEncryptUserId)
          {
               $userId = $this->repository('Siropu\ReferralSystem:Referrer')->getHashId($userId);
          }

          $urlParameter = $options->siropuReferralSystemReferralUrlParameter;
          $affiliateUrl = $url . (strpos($url, '?') === false ? '?' : '&') . $urlParameter . '=' . $userId;

          $reply = $this->view();
          $reply->setJsonParams(['affiliateUrl' => $affiliateUrl]);

          return $reply;
     }
     public function actionReferralFaq()
     {
          $view = $this->view('XF:Account\ReferralFaq', 'siropu_referral_system_account_referral_faq');
          return $this->addAccountWrapperParams($view, 'referral_faq');
     }
     public function getReferralToolRepo()
     {
          return $this->repository('Siropu\ReferralSystem:Tool');
     }
     protected function assertReferralToolExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\ReferralSystem:Tool', $id, $with, 'siropu_referral_system_tool_not_found');
     }
}
