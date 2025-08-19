<?php

namespace Siropu\AdsManager\Finder;

use XF\Mvc\Entity\Finder;

class Invoice extends Finder
{
     public function forUser($userId)
     {
          $this->where('user_id', $userId);
          return $this;
     }
     public function forAd($adId)
     {
          $this->where('ad_id', $adId);
          return $this;
     }
     public function ofStatus($status)
     {
          $this->where('status', $status);
          return $this;
     }
     public function notOfStatus($status)
     {
          $this->where('status', '<>', $status);
          return $this;
     }
     public function withPromoCode($promoCode)
     {
          $this->where('promo_code', $promoCode);
          return $this;
     }
     public function isRecurring()
     {
          $this->where('recurring', 1);
          return $this;
     }
     public function isParent()
     {
          $this->where('child_ids', '');
          return $this;
     }
}
