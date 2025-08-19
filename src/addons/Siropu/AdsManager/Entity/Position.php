<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Position extends Entity
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_position';
          $structure->shortName  = 'AdsManager:Position';
          $structure->primaryKey = 'position_id';

          $structure->columns = [
               'position_id'   => ['type' => self::STR, 'maxLength' => 50, 'required' => 'siropu_ads_manager_position_id_required', 'unique' => 'siropu_ads_manager_position_id_must_be_unique', 'match' => 'alphanumeric'],
               'title'         => ['type' => self::STR, 'maxLength' => 100, 'required' => 'please_enter_valid_title'],
               'description'   => ['type' => self::STR, 'maxLength' => 255, 'default' => ''],
               'category_id'   => ['type' => self::UINT, 'default' => 0],
               'is_default'    => ['type' => self::UINT, 'default' => 0],
               'display_order' => ['type' => self::UINT, 'default' => 0]
          ];

          $structure->getters   = [];

          $structure->relations = [
               'Category' => [
                    'entity'     => 'Siropu\AdsManager:PositionCategory',
                    'type'       => self::TO_ONE,
                    'conditions' => 'category_id'
               ]
          ];

          $structure->defaultWith = ['Category'];

          return $structure;
     }
     public function isVisible()
     {
          if ($this->Category && !$this->Category->isVisible())
          {
               return false;
          }

          $hiddenPositions = ['embed', 'content_thread', 'content_conversation', 'content_profile', 'javascript', 'advertisers'];

          if (in_array($this->position_id, $hiddenPositions))
          {
               return false;
          }

          return true;
     }
     public function isDynamic()
     {
          return preg_match('/_$/', $this->position_id);
     }
     public function getBreadcrumbs($includeSelf = true)
	{
          $breadcrumbs = [
               [
                    'href'  => $this->app()->router()->buildLink('ads-manager/positions'),
                    'value' => \XF::phrase('siropu_ads_manager_positions')
               ]
          ];

          if ($includeSelf)
          {
               $breadcrumbs[] = [
				'href'  => $this->app()->router()->buildLink('ads-manager/positions/edit', $this),
				'value' => $this->title
			];
          }

          return $breadcrumbs;
     }
     protected function _postSave()
     {

     }
     protected function _postDelete()
     {

     }
}
