<?php

namespace FS\ForumListBgTextClr\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Node extends XFCP_Node
{
	public static function getStructure(Structure $structure)
	{
		$structure = parent::getStructure($structure);

		$structure->columns['txt_clr'] = ['type' => self::STR, 'maxLength' => 50, 'default' => ''];
		$structure->columns['bg_clr'] = ['type' => self::STR, 'maxLength' => 50, 'default' => ''];

		return $structure;
	}
}
