<?php

namespace Siropu\ReferralSystem\Admin\Controller;

use XF\Mvc\ParameterBag;

class Referrer extends AbstractController
{
     public function actionDecrypt(ParameterBag $params)
     {
          $viewParams = [];

          if ($this->isPost())
          {
               $referrerId = $this->filter('referrer_id', 'str');

               if ($referrerId)
               {
                    $userId = $this->repository('Siropu\ReferralSystem:Referrer')->getHashId($referrerId, false);

                    if ($userId)
                    {
                         $viewParams['userId'] = $userId;
                         $viewParams['user']   = $this->em()->find('XF:User', $userId);
                    }
               }
          }

          return $this->view('Siropu\ReferralSystem:Referrer\Decrypt', 'siropu_referral_system_referrer_decrypt', $viewParams);
     }
}
