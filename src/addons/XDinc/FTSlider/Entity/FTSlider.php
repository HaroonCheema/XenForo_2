<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider\Entity;

use XF\Mvc\Entity\Structure;

class FTSlider extends \XF\Mvc\Entity\Entity
{
	public function canEdit()
	{
		$thread = $this->Thread;
		$visitor = \XF::visitor();

		if ($visitor->hasPermission('FTSlider_permissions', 'FTSlider_moderate'))
		{
			return true;
		}

		if ($visitor->hasPermission('FTSlider_permissions', 'FTSlider_submit')
			&& $visitor->user_id == $thread->user_id)
		{
			return true;
		}

		return false;
	}
	/*** Get Image ***/	

	public function getImage()
	{
		$image = \XF::getRootDirectory() . '/data/FTSlider/' . $this->thread_id . '.jpg';

		if (file_exists($image))
		{
			return 'data/FTSlider/' . $this->thread_id . '.jpg?' . $this->ftslider_time;
		}

		return "styles/FTSlider/default.png";
	}

	protected function _preSave()
	{
		$this->ftslider_time = \XF::$time;
	}

	protected function _postDelete()
	{
		$image = \XF::getRootDirectory() . '/data/FTSlider/' . $this->thread_id . '.jpg';
		if (file_exists($image)) { unlink($image); }
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xd_ftslider_features';
		$structure->shortName = 'XDinc\FTSlider:FTSlider';
		$structure->primaryKey = 'thread_id';
		$structure->columns = [
			'thread_id' =>				['type' => self::UINT, 'required' => true],
			'ftslider_date' =>			['type' => self::UINT, 'required' => true],
			'ftslider_time' =>			['type' => self::UINT, 'required' => true],
			'ftslider_title' =>			['type' => self::STR, 'required' => false, 'default' => ''],
			'ftslider_excerpt' =>		['type' => self::STR, 'required' => false, 'default' => ''],
			'ftslider_imgurl' =>		['type' => self::STR, 'required' => false, 'default' => ''],
			'ftslider_icon' =>			['type' => self::SERIALIZED_ARRAY, 'required' => false, 'default' => []],
		];
		$structure->getters = [
			'image' => true,
		];

		$structure->relations = [

				'Thread' => [
				'entity' => 'XF:Thread',
				'type' => self::TO_ONE,
				'conditions' => 'thread_id',
				'primary' => true,
			],
		];

		return $structure;
	}
}