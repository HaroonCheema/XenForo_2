<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class DailyStats extends AbstractStats
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_stats_daily';
          $structure->shortName  = 'AdsManager:DailyStats';
          $structure->primaryKey = ['ad_id', 'position_id', 'stats_date'];

          $structure->columns = [
               'stats_date'  => ['type' => self::UINT, 'default' => \XF::repository('Siropu\AdsManager:DailyStats')->getStatsDate()],
               'ad_id'       => ['type' => self::UINT, 'required' => true],
               'position_id' => ['type' => self::STR, 'maxLength' => 50, 'match' => 'alphanumeric', 'required' => true],
               'view_count'  => ['type' => self::UINT, 'default' => 0],
               'click_count' => ['type' => self::UINT, 'default' => 0]
          ];

          $structure->getters = [
               'date'           => false,
               'ctr'            => false,
               'position_data'  => false,
               'position_title' => false
          ];

          $structure->options = [
               'display_date' => '',
          ];

          $structure->relations = [
               'Ad' => [
                    'entity'     => 'Siropu\AdsManager:Ad',
                    'type'       => self::TO_ONE,
                    'conditions' => 'ad_id'
               ],
               'Position' => [
                    'entity'     => 'Siropu\AdsManager:Position',
                    'type'       => self::TO_ONE,
                    'conditions' => 'position_id'
               ]
          ];

          $structure->defaultWith = ['Ad'];

          return $structure;
     }
     public function getCtr()
     {
          if ($this->view_count && $this->click_count)
          {
               return number_format(min($this->click_count / $this->view_count * 100, 100), 2);
          }

          return 0;
     }
     public function getDate()
     {
          return $this->getOption('display_date');
     }
     protected function getDailyStatsRepo()
     {
          return $this->repository('Siropu\AdsManager:DailyStats');
     }
}
