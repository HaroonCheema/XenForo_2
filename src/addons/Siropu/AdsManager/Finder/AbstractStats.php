<?php

namespace Siropu\AdsManager\Finder;

use XF\Mvc\Entity\Finder;

class AbstractStats extends Finder
{
     public function dateBetween($start, $end)
     {
          $this->where('stats_date', 'BETWEEN', [$start, $end]);
          return $this;
     }
     public function sinceDate($date)
     {
          $this->where('stats_date', '>=', $date);
          return $this;
     }
     public function untilDate($date)
     {
          $this->where('stats_date', '<=', $date);
          return $this;
     }
     public function forPosition($positionId)
     {
          $this->where('position_id', $positionId);
          return $this;
     }
}
