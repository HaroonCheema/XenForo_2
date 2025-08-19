<?php

namespace Siropu\AdsManager\Finder;

use XF\Mvc\Entity\Finder;

class Ad extends Finder
{
     public function active()
     {
          $this->where('status', 'active');
          return $this;
     }
     public function inactive()
     {
          $this->where('status', 'inactive');
          return $this;
     }
     public function pending()
     {
          $this->where('status', 'pending');
          return $this;
     }
     public function approved()
     {
          $this->where('status', 'approved');
          return $this;
     }
     public function queued()
     {
          $this->where('status', 'queued');
          return $this;
     }
     public function archived()
     {
          $this->where('status', 'archived');
          return $this;
     }
     public function rejected()
     {
          $this->where('status', 'rejected');
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
     public function displayable()
     {
          $this->where('type', ['code', 'banner', 'text', 'link', 'popup', 'background']);
          return $this;
     }
     public function embeddable()
     {
          $this->where('type', ['code', 'banner', 'text', 'link']);
          return $this;
     }
     public function forPackage($packageId)
     {
          $this->where('package_id', $packageId);
          return $this;
     }
     public function forUser($userId)
     {
          $this->where('user_id', $userId);
          return $this;
     }
     public function hasExpired()
     {
          $this->where('end_date', '<>', 0);
          $this->where('end_date', '<', \XF::$time);
          return $this;
     }
     public function havingContent($content)
     {
          $this->where('content_1', 'LIKE', $this->escapeLike($content, '%?%'));
          return $this;
     }
     public function isPurchase()
     {
          $this->where('Extra.purchase', '<>', 0);
          return $this;
     }
     public function randomOrder()
     {
          $this->order($this->expression('RAND()'));
          return $this;
     }
}
