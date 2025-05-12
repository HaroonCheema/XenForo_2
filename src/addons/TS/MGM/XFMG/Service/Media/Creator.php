<?php

namespace TS\MGM\XFMG\Service\Media;

class Creator extends XFCP_Creator {
	
	public function createAdditionalCategories() {
		
		if(isset($this->additionalCategories)) {
			
			foreach($this->additionalCategories as $category) {
				
				$exists = $this->em()->findOne("XFMG:Category", ["category_id" => $category]);
				
				if($exists && $exists->canAddMedia()) {
					
					$new = $this->em()->create("TS\MGM:Additional");
					$new->media_id = $this->mediaItem->media_id;
					$new->additional_id = $category;
					$new->save();
					
				}
				
			}
			
		}
		
	}
	
	public function setAdditionalCategories($categories) {
		
		$this->additionalCategories = $categories;
		
	}
	
}