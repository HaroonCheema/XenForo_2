<?php

namespace TS\MGM\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Additional extends Entity {
	
	
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_ts_mgm_additional';
		$structure->shortName = 'TS\MGM:Additional';
		$structure->primaryKey = 'entity_id';
		$structure->columns = [
			'entity_id' => ['type' => self::UINT, 'maxLength' => 10,
				'autoIncrement' => true,
				'nullable' => true,
			],
			'media_id' => ['type' => self::UINT, 'required' => true, 'maxLength' => 10],
			'additional_id' => ['type' => self::UINT, 'required' => true, 'maxLength' => 10],
		];
		
		$structure->relations = [
			'MediaItem' => [
				'entity' => 'XFMG:MediaItem',
				'type' => self::TO_ONE,
				'conditions' => [['media_id', '=', '$media_id'], 
								['category_id', '=', '$additional_id']],
			]
		];

		return $structure;
	}	
	
	
}