<?php

namespace TS\MGC\Cron;

class Rebuild {
	
	
	public static function runCron() {
		
		$userRepo = \XF::repository("XF:User");
		$userRepo->rebuildAllGalleryCommentCounters();
			
	}
	
	
}