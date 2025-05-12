<?php

namespace TS\MGM\Repository;

use XF\Mvc\Entity\Repository;

class Additional extends Repository
{
	
	public function findAdditionalItems($sourceCategoryIds) {
		
		$raw = $this->finder("TS\MGM:Additional")
					->where("additional_id", $sourceCategoryIds)
					->fetch();
		
		$mediaIds = array_unique($raw->pluckNamed("media_id"));
		
		$additionalMedia = $this->finder("XFMG:MediaItem")
								->where("media_id", $mediaIds)
								->fetch();
								
		return $additionalMedia;
	}
	
	public function findAdditionalCategories($sourceMediaIds) {
		
		$raw = $this->finder("TS\MGM:Additional")
					->where("media_id", $sourceMediaIds)
					->fetch();
		
		$mediaIds = array_unique($raw->pluckNamed("additional_id"));
		
		$additionalMedia = $this->finder("XFMG:Category")
								->where("category_id", $mediaIds)
								->fetch();
								
		return $additionalMedia;
	}	
}