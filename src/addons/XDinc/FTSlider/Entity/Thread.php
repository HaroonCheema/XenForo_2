<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
	protected function _postDelete()
	{
		if ($this->FTSlider)
		{
			$this->db()->delete('xd_ftslider_features', 'thread_id = ?', $this->thread_id);
			
			$image = \XF::getRootDirectory() . '/data/FTSlider/' . $this->thread_id . '.jpg';
			if (file_exists($image)) { unlink($image); }
		}
		
		return parent::_postDelete();
	}
	
	public static function getStructure(Structure $structure)
	{
		$parent = parent::getStructure($structure);
		 
		 $structure->relations['FTSlider'] = [
			'entity' => 'XDinc\FTSlider:FTSlider',
			'type' => self::TO_ONE,
			'conditions' => 'thread_id',
			'key' => 'ftslider_id',
		];
		
        return $parent;
    }
}