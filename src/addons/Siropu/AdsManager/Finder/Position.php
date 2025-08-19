<?php

namespace Siropu\AdsManager\Finder;

use XF\Mvc\Entity\Finder;

class Position extends Finder
{
     public function inCategory($categoryId)
     {
          $this->where('category_id', $categoryId);
          return $this;
     }
}
