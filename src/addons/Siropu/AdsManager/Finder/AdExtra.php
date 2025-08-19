<?php

namespace Siropu\AdsManager\Finder;

use XF\Mvc\Entity\Finder;

class AdExtra extends Finder
{
     public function havingExclusiveKeyword($keyword)
     {
          $this->where('exclusive_keywords', 'LIKE', $this->escapeLike($keyword, '%?%'));
          return $this;
     }
}
