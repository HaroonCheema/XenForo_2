<?php

namespace TS\MGM\XFMG\Repository;

class Media extends XFCP_Media {
	
	public function findMediaInCategory($categoryId, array $limits = [])
	{
		
		$additionalItems = $this->repository("TS\MGM:Additional")
				->findAdditionalItems($categoryId)
				->filterViewable()
				->pluckNamed("media_id");
		
		$finder = $this->findMediaForList($limits);
		$finder->whereOr([["category_id" => $categoryId], ["media_id" => $additionalItems]]);

		return $finder;
		
	}	
	
	
	
}