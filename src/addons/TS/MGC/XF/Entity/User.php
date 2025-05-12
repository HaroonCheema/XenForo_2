<?php

namespace TS\MGC\XF\Entity;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class User extends XFCP_User {
	
	
	public function changeCommentCounter($count) {
		
		$this->ts_mgc_counter += $count;
		$this->save();
		
	}
	
	public function rebuildGalleryCommentCounter($newTransaction = true) {
	
		$db = $this->db();
		$userId = $this->user_id;
		
		$query = "
			SELECT COUNT(*)
			FROM xf_mg_comment xc
			LEFT JOIN xf_mg_media_item xm ON (xc.content_id = xm.media_id)
			WHERE xc.user_id = ?
			AND xc.comment_state = 'visible'
			AND xm.media_state = 'visible' 
		";
		
		if(\XF::options()->ts_mgc_time_window == 'recent')
			$query .= "AND xc.comment_date BETWEEN (UNIX_TIMESTAMP() - 30 * 86400) AND UNIX_TIMESTAMP()";
		elseif(\XF::options()->ts_mgc_time_window == 'march')
			$query .= "AND xc.comment_date BETWEEN 1551416400 AND UNIX_TIMESTAMP()";
			
		$commentCount = $this->db()->fetchOne($query, $userId);
		
		$commentCount = intval($commentCount);
		
		if($newTransaction)
		{
			$db->beginTransaction();
		}

		$db->update('xf_user', 
					['ts_mgc_counter' => $commentCount], 
					'user_id = ?', $userId);
					
		if ($newTransaction)
		{
			$db->commit();
		}
		
	}
	
	public static function getStructure(Structure $structure) {
	
		$struc = parent::getStructure($structure);
		$struc->columns["ts_mgc_counter"] = ['type' => self::UINT, 'default' => 0];
		
		return $struc;
	
	}
	
	
	
}