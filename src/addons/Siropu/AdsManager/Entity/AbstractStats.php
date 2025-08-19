<?php

namespace Siropu\AdsManager\Entity;

class AbstractStats extends \XF\Mvc\Entity\Entity
{
     public function getPositionTitle()
     {
          $position = $this->getPositionRepo()->getDynamicPosition($this->position_id);

          if ($position)
          {
               return $position->title;
          }
          else
          {
               return \XF::phrase('n_a');
          }
     }
     public function getPositionData()
     {
          return $this->getPositionRepo()->getDynamicPosition($this->position_id);
     }
     protected function getPositionRepo()
     {
          return $this->repository('Siropu\AdsManager:Position');
     }
}
