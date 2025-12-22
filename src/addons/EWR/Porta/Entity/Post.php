<?php

namespace EWR\Porta\Entity;

use XF\Mvc\Entity\Structure;

class Post extends XFCP_Post
{
	public static function getStructure(Structure $structure)
	{
		$parent = parent::getStructure($structure);
		
		$structure->relations['PortaAuthor'] = [
			'entity' => 'EWR\Porta:Author',
			'type' => self::TO_ONE,
			'conditions' => 'user_id',
		];
		
		return $parent;
	}
}