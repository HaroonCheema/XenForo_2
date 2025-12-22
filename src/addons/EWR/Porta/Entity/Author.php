<?php

namespace EWR\Porta\Entity;

use XF\Mvc\Entity\Structure;

class Author extends \XF\Mvc\Entity\Entity
{
	public function canEdit()
	{
		$visitor = \XF::visitor();
		
		if ($visitor->hasAdminPermission('EWRporta'))
		{
			return true;
		}
		
		if ($visitor->user_id == $this->user_id)
		{
			return true;
		}
		
		return false;
	}
	
	public function getImage()
	{
		$image = 'data://authors/'.$this->user_id.'.jpg';
		
		if (\XF\Util\File::abstractedPathExists($image))
		{
			return $this->app()->applyExternalDataUrl('authors/' . $this->user_id . '.jpg?' . $this->author_time, true);
		}
	
		return "styles/8wayrun/porta/_author.jpg";
	}
	
	protected function _preSave()
	{
		$this->author_time = \XF::$time;
	}
	
	protected function _postDelete()
	{
		\XF\Util\File::deleteFromAbstractedPath('data://authors/'.$this->user_id.'.jpg');
	}
	
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'ewr_porta_authors';
		$structure->shortName = 'EWR\Porta:Author';
		$structure->primaryKey = 'user_id';
		$structure->columns = [
			'user_id' =>				['type' => self::UINT, 'required' => true],
			'author_name' =>			['type' => self::STR, 'required' => false, 'default' => ''],
			'author_byline' =>			['type' => self::STR, 'required' => false, 'default' => '', 'censor' => true],
			'author_status' =>			['type' => self::STR, 'required' => false, 'default' => '', 'censor' => true],
			'author_order' =>			['type' => self::UINT, 'required' => true],
			'author_time' =>			['type' => self::UINT, 'required' => true],
		];
		$structure->getters = [
			'image' => true,
		];
		$structure->relations = [
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true,
			],
		];

		return $structure;
	}
}