<?php

namespace Siropu\ReferralSystem\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class SpamCleaner extends XFCP_SpamCleaner
{
     public function filterSpamCleanActions()
     {
          $actions = parent::filterSpamCleanActions();
          $actions['siropu_referral_system']  = $this->filter('siropu_referral_system', 'array-uint');

          return $actions;
     }
}
