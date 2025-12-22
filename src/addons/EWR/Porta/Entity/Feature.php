<?php

namespace EWR\Porta\Entity;

use XF\Mvc\Entity\Structure;

class Feature extends \XF\Mvc\Entity\Entity
{
	public function canEdit()
	{
		$thread = $this->Thread;
		$visitor = \XF::visitor();
		
		if ($visitor->hasPermission('EWRporta', 'modFeatures'))
		{
			return true;
		}
		
		if ($visitor->hasPermission('EWRporta', 'submitFeatures')
			&& $visitor->user_id == $thread->user_id)
		{
			return true;
		}
		
		return false;
	}
	
	public function getImage()
	{
		$image = 'data://features/'.$this->thread_id.'.jpg';
		
		if (\XF\Util\File::abstractedPathExists($image))
		{
			return $this->app()->applyExternalDataUrl('features/' . $this->thread_id . '.jpg?' . $this->feature_time, true);
		}
	
		return "styles/8wayrun/porta/_feature.jpg";
	}
	
	protected function _preSave()
	{
		$this->feature_time = \XF::$time;
	}
	
	protected function _postDelete()
	{
		\XF\Util\File::deleteFromAbstractedPath('data://features/'.$this->thread_id.'.jpg');
	}
	
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'ewr_porta_features';
		$structure->shortName = 'EWR\Porta:Feature';
		$structure->primaryKey = 'thread_id';
		$structure->columns = [
			'thread_id' =>				['type' => self::UINT, 'required' => true],
			'feature_date' =>			['type' => self::UINT, 'required' => true],
			'feature_time' =>			['type' => self::UINT, 'required' => true],
			'feature_title' =>			['type' => self::STR, 'required' => false, 'default' => '', 'censor' => true],
			'feature_excerpt' =>		['type' => self::STR, 'required' => false, 'default' => '', 'censor' => true],
			'feature_media' =>			['type' => self::STR, 'required' => false, 'default' => ''],
		];
		$structure->getters = [
			'image' => true,
		];
		$structure->relations = [
			'CatLink' => [
				'entity' => 'EWR\Porta:CatLink',
				'type' => self::TO_ONE,
				'conditions' => 'thread_id',
			],
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