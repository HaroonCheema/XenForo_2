<?php

namespace XenBulletins\BrandHub\XF\Repository;

class Tag extends XFCP_Tag
{    
        
        public function getTagsThreadSearchResults($tagIds, $limit = 0, $userId = null, $visibleOnly = true)  //pass userId to get discussions of ownerPage
	{
		$limit = intval($limit);

                $quotedTagIds = $this->db()->quote($tagIds);
                
                $defaultSortOrder = $this->options()->bh_defaultSortOrderOfDiscussions;
                
                $order = $defaultSortOrder['order'];
                $direction = $defaultSortOrder['direction'];
                
		$results = $this->db()->query("
			SELECT DISTINCT tc.content_id, tc.content_type
			FROM xf_tag_content as tc
                        INNER JOIN xf_thread AS t ON t.thread_id = tc.content_id
			WHERE tc.tag_id IN (" . $quotedTagIds . ")
				" . ($visibleOnly ? "AND tc.visible = 1" : '') . "
                                " . ($userId ? "AND tc.add_user_id = {$userId}" : '') . "    
                                        AND tc.content_type = 'thread'
			ORDER BY t.{$order} {$direction}
                        " . ($limit ? "LIMIT {$limit}" : '') . "
		");
                        
                        
                        
		$output = [];
//		while ($result = $results->fetch())
//		{       
//			$type = $result['content_type'];
//			$id = $result['content_id'];
//			$output["{$type}-{$id}"] = [$type, $id];
//		}
               
                
                
                $results = $results->fetchAll();

                
                foreach ($results as $result)
                {
                    $type = $result['content_type'];
                    $id = $result['content_id'];
                    $output["{$type}-{$id}"] = [$type, $id];
                }

		return $output;
	}
        
        
        
        
        public function getTagsThreadCount($tagIds, $userId = null, $visibleOnly = true)  //pass userId to get discussions of ownerPage
	{
                $quotedTagIds = $this->db()->quote($tagIds);
                
		$results = $this->db()->query("
			SELECT DISTINCT tc.content_id
			FROM xf_tag_content as tc
			WHERE tc.tag_id IN (" . $quotedTagIds . ")
				" . ($visibleOnly ? "AND tc.visible = 1" : '') . "
                                " . ($userId ? "AND tc.add_user_id = {$userId}" : '') . "    
                                        AND tc.content_type = 'thread'
		");
         
                
                $count = count($results->fetchAll());

                return $count;
	}
}