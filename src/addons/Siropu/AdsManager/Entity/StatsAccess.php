<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class StatsAccess extends AbstractStats
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_stats_access';
          $structure->shortName  = 'AdsManager:StatsAccess';
          $structure->primaryKey = 'access_key';

          $structure->columns = [
               'access_key'  => ['type' => self::STR, 'required' => true],
               'ad_list'     => ['type' => self::LIST_COMMA, 'required' => 'siropu_ads_manager_ad_is_required',
                    'list' => ['type' => 'posint', 'unique' => true, 'sort' => SORT_NUMERIC]],
               'title'       => ['type' => self::STR, 'required' => 'please_enter_valid_title'],
               'access_date' => ['type' => self::UINT, 'default' => 0]
          ];

          return $structure;
     }
}
