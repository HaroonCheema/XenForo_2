<?php

namespace Siropu\AdsManager\Finder;

use XF\Mvc\Entity\Finder;

class Package extends Finder
{
     public function ofType($type)
     {
          $this->where('type', $type);
          return $this;
     }
     public function notOfType($type)
     {
          $this->where('type', '<>', $type);
          return $this;
     }
}
