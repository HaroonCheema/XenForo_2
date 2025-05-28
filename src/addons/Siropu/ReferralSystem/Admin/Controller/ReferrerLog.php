<?php

namespace Siropu\ReferralSystem\Admin\Controller;

use XF\Mvc\ParameterBag;

class ReferrerLog extends AbstractController
{
     public function actionIndex(ParameterBag $params)
     {
          $linkParams = [];
          $page       = $this->filterPage();
          $perPage    = 20;

          $finder = $this->finder('Siropu\ReferralSystem:ReferrerLog')
               ->order('date', 'desc')
               ->limitByPage($page, $perPage);

          if ($referrer = $this->filter('referrer', 'str'))
          {
               $user = $this->em()->findOne('XF:User', ['username' => $referrer]);

               if ($user)
               {
                    $finder->where('user_id', $user->user_id);
                    $linkParams['referrer'] = $referrer;
               }
          }

          $viewParams = [
               'entries'    => $finder->fetch(),
               'total'      => $finder->total(),
               'page'       => $page,
               'perPage'    => $perPage,
               'linkParams' => $linkParams
          ];

          return $this->view('Siropu\ReferralSystem:ReferrerLog', 'siropu_referral_system_referrer_log_list', $viewParams);
     }
     public function actionDelete(ParameterBag $params)
     {
          $referrerLog = $this->assertReferrerLogExists($params->log_id);
          $plugin     = $this->plugin('XF:Delete');

          return $plugin->actionDelete(
               $referrerLog,
               $this->buildLink('referral-system/referrer-log/delete', $referrerLog),
               null,
               $this->buildLink('referral-system/referrer-log/'),
               $referrerLog->log_id
          );
     }
     public function actionClear(ParameterBag $params)
     {
          if ($this->isPost())
          {
               \XF::db()->emptyTable('xf_siropu_referral_system_referrer_log');
               return $this->redirect($this->buildLink('referral-system/referrer-log'));
          }

          return $this->view('Siropu\ReferralSystem:ReferrerLog\Clear', 'siropu_referral_system_referrer_log_clear');
     }
     protected function assertReferrerLogExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\ReferralSystem:ReferrerLog', $id, $with, 'requested_log_entry_not_found');
     }
}
