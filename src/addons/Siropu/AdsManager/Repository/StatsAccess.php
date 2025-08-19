<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class StatsAccess extends Repository
{
     public function generateAccessKey()
     {
          $finder = $this->finder('Siropu\AdsManager:StatsAccess');

          do
          {
               $accessKey = md5(microtime(true) . \XF::generateRandomString(8, true));

               $found = $finder->resetWhere()
                    ->where('access_key', $accessKey)
                    ->fetchOne();

               if (!$found)
               {
                    break;
               }
          }
          while (true);

          return $accessKey;
     }
}
