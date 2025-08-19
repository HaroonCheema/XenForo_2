<?php

namespace Siropu\AdsManager\Finder;

use XF\Mvc\Entity\Finder;

class PromoCode extends Finder
{
     public function enabled()
     {
          $this->where('enabled', 1);
          return $this;
     }
}
