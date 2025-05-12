<?php

namespace TS\MGC\XF\Repository;

class User extends XFCP_User {
	
	public function rebuildAllGalleryCommentCounters() {
		
		$users = $this->findValidUsers()->fetch();
		
		foreach($users as $user)
			$user->rebuildGalleryCommentCounter();
		
	}
	
	
	
}