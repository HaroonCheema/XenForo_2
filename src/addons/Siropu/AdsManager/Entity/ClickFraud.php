<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class ClickFraud extends AbstractStats
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_click_fraud';
          $structure->shortName  = 'AdsManager:ClickFraud';
          $structure->primaryKey = ['ad_id', 'ip'];

          $structure->columns = [
               'ad_id'       => ['type' => self::STR, 'required' => true],
               'ip'          => ['type' => self::BINARY, 'maxLength' => 16, 'required' => true],
               'ip_blocked'  => ['type' => self::UINT, 'default' => 0],
               'page_url'    => ['type' => self::STR, 'default' => ''],
               'log_date'    => ['type' => self::UINT, 'default' => 0],
               'click_count' => ['type' => self::UINT, 'default' => 0]
          ];

          $structure->relations = [
               'Ad' => [
                    'entity'     => 'Siropu\AdsManager:Ad',
                    'type'       => self::TO_ONE,
                    'conditions' => 'ad_id',
                    'primary'    => true
               ]
          ];

          return $structure;
     }
     public function isIpBlocked()
     {
          return $this->ip_blocked > \XF::$time;
     }
}
