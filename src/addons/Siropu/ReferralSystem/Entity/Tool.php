<?php

namespace Siropu\ReferralSystem\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Tool extends Entity
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_referral_system_referral_tool';
          $structure->shortName  = 'ReferralSystem:Tool';
          $structure->primaryKey = 'tool_id';

          $structure->columns = [
               'tool_id'     => ['type' => self::UINT, 'autoIncrement' => true],
               'type'        => ['type' => self::STR, 'default' => 'banner'],
               'name'        => ['type' => self::STR, 'required' => 'please_enter_valid_name'],
               'content'     => ['type' => self::STR, 'default' => ''],
               'size'        => ['type' => self::STR, 'default' => ''],
               'target_url'  => ['type' => self::STR, 'match' => 'url_empty', 'default' => ''],
               'click_count' => ['type' => self::UINT, 'default' => 0],
               'enabled'     => ['type' => self::UINT, 'default' => 1]
          ];

          $structure->getters = [
               'type_phrase'        => true,
               'absolute_file_path' => true
          ];

          return $structure;
     }
     public function isBanner()
     {
          return $this->type == 'banner';
     }
     public function isText()
     {
          return $this->type == 'text';
     }
     public function getTypePhrase()
     {
          return \XF::phrase('siropu_referral_system_type.' . $this->type);
     }
     public function getAbsoluteFilePath()
     {
          return $this->app()->applyExternalDataUrl('siropu/rs/' . $this->content, true);
     }
     public function countClick()
     {
          $this->fastUpdate('click_count', $this->click_count + 1);
     }
	protected function _postDelete()
	{
          if ($this->isBanner())
          {
               \XF\Util\File::deleteFromAbstractedPath('data://siropu/rs/' . $this->content);
          }
	}
}
