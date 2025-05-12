<?php

namespace TS\MGM\XFMG\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MediaItem extends XFCP_MediaItem {

	public function getAdditionalCategories() {
		
		$additionalItems = $this->repository("TS\MGM:Additional")
					->findAdditionalCategories($this->media_id)
					->filterViewable();
		
		return $additionalItems;
		
	}
	
}