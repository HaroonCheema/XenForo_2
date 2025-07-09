<?php

namespace FS\DiscussionThread\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Node extends XFCP_Node
{
    public static function getStructure(Structure $structure)
	{
		$structure = parent::getStructure($structure);
        
        $structure->columns['disc_node_id'] = ['type' => self::UINT, 'default' => 0];
        
		return $structure;
	}
}