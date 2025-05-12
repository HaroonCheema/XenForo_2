<?php

namespace TS\MGM\XFMG\Entity;

class Category extends XFCP_Category {
	
	
	public function getCategoryListExtras()
	{
		
		$parent = parent::getCategoryListExtras();
		
		$additionalItems = $this->repository("TS\MGM:Additional")
					->findAdditionalItems($this->category_id)
					->filterViewable();
					
		$parent['media_count'] = $this->media_count + $additionalItems->count();
		
		return $parent;
	}	
	
}