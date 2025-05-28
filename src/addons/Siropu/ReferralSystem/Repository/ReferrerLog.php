<?php

namespace Siropu\ReferralSystem\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class ReferrerLog extends Repository
{
     public function logHttpReferrer($referrerId)
     {
          if (\XF::options()->siropuReferralSystemTrackHttpReferrer && ($referrer = \XF::app()->request()->getReferrer()))
          {
               $log = $this->em->create('Siropu\ReferralSystem:ReferrerLog');
               $log->user_id = $referrerId;
               $log->url = $referrer;
               $log->save();
          }
     }
}
