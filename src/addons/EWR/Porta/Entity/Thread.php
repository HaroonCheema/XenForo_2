<?php

namespace EWR\Porta\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
	public function isPortaArticle()
	{
		if (\XF::options()->EWRporta_article_format['article'] &&
			!empty($this->PortaArticle->article_format))
		{
			return true;
		}
		
		return false;
	}
	
	public function showPortaAttach()
	{
		if ($this->isPortaArticle() && \XF::options()->EWRporta_article_format['attach'])
		{
			return true;
		}
		
		return false;
	}
	
	public function showPortaComments()
	{
		if ($this->isPortaArticle() && \XF::options()->EWRporta_article_format['comments'])
		{
			return true;
		}
		
		return false;
	}
	
	public function showPortaAuthor()
	{
		if ($this->isPortaArticle() && \XF::options()->EWRporta_article_format['author'] &&
			!empty($this->FirstPost->PortaAuthor))
		{
			return true;
		}
		
		return false;
	}
	
	protected function _postDelete()
	{
		if ($this->PortaArticle)
		{
			$this->db()->delete('ewr_porta_articles', 'thread_id = ?', $this->thread_id);
			$this->db()->delete('ewr_porta_catlinks', 'thread_id = ?', $this->thread_id);
		}
		
		if ($this->PortaFeature)
		{
			$this->db()->delete('ewr_porta_features', 'thread_id = ?', $this->thread_id);
			
			$image = \XF::getRootDirectory() . '/data/features/' . $this->thread_id . '.jpg';
			if (file_exists($image)) { unlink($image); }
		}
		
		return parent::_postDelete();
	}
	
	public static function getStructure(Structure $structure)
	{
		$parent = parent::getStructure($structure);
		
		$structure->relations['PortaArticle'] = [
			'entity' => 'EWR\Porta:Article',
			'type' => self::TO_ONE,
			'conditions' => 'thread_id',
			'key' => 'article_id',
		];
		$structure->relations['PortaFeature'] = [
			'entity' => 'EWR\Porta:Feature',
			'type' => self::TO_ONE,
			'conditions' => 'thread_id',
			'key' => 'feature_id',
		];
		
		return $parent;
	}
}