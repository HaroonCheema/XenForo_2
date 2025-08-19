<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class PositionCategory extends Entity
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_position_category';
          $structure->shortName  = 'AdsManager:PositionCategory';
          $structure->primaryKey = 'category_id';

          $structure->columns = [
               'category_id'   => ['type' => self::UINT, 'autoIncrement' => true],
               'title'         => ['type' => self::STR, 'maxLenth' => 255, 'required' => 'please_enter_valid_title'],
               'description'   => ['type' => self::STR, 'maxLength' => 255, 'default' => ''],
               'display_order' => ['type' => self::UINT, 'default' => 0]
          ];

          $structure->relations = [
               'Positions' => [
                    'entity'     => 'Siropu\AdsManager:Position',
                    'type'       => self::TO_MANY,
                    'conditions' => 'category_id'
               ]
          ];

          return $structure;
     }
     public function isVisible()
     {
          if ($this->category_id == 10 && !\XF::em()->find('XF:AddOn', 'XFMG')
               || $this->category_id == 11 && !\XF::em()->find('XF:AddOn', 'XFRM')
               || $this->category_id == 12 && !\XF::em()->find('XF:AddOn', 'XenAddons/AMS')
               || $this->category_id == 15 && !\XF::em()->find('XF:AddOn', 'XenAddons/Showcase'))
          {
               return false;
          }

          return true;
     }
     public function getPositionCount()
     {
          return $this->Positions->count();
     }
     protected function _postDelete()
     {
          $this->repository('Siropu\AdsManager:Position')->changePositionCategory($this->category_id);
     }
}
