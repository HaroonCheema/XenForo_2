<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class ClickStats extends AbstractStats
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_stats_click';
          $structure->shortName  = 'AdsManager:ClickStats';
          $structure->primaryKey = 'click_id';

          $structure->columns = [
               'click_id'    => ['type' => self::UINT, 'autoIncrement' => true],
               'stats_date'  => ['type' => self::UINT, 'default' => \XF::$time],
               'ad_id'       => ['type' => self::UINT, 'required' => true],
               'position_id' => ['type' => self::STR, 'maxLength' => 50, 'match' => 'alphanumeric', 'required' => true],
               'image_url'   => ['type' => self::STR, 'match' => 'url_empty', 'default' => ''],
               'page_url'    => ['type' => self::STR, 'match' => 'url_empty', 'default' => ''],
               'visitor'     => ['type' => self::JSON_ARRAY, 'default' => []]
          ];

          $structure->getters   = [
               'position_data'  => false,
               'position_title' => false
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
     public function getVisitor()
     {
          return $this->app()->em()->instantiateEntity('XF:User', $this->visitor);
     }
     public function getDevice()
     {
          return $this->visitor['device'];
     }
     protected function getClickStatsRepo()
     {
          return $this->repository('Siropu\AdsManager:ClickStats');
     }
}
