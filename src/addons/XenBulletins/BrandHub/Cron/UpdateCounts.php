<?php

namespace XenBulletins\BrandHub\Cron;


class UpdateCounts
{
        public static function updateItemsDiscussionCount()
        {   
            $app = \XF::app();
            $jobID = 'bh_Update_itemDiscussionCount';
            
            $app->jobManager()->enqueueUnique($jobID, 'XenBulletins\BrandHub:ItemDiscussionCount', [],false);
        }
        
        
        public static function updateOwnerPageDiscussionCount()
        {   
            $app = \XF::app();
            $jobID = 'bh_Update_ownerPageDiscussionCount';
            
            $app->jobManager()->enqueueUnique($jobID, 'XenBulletins\BrandHub:OwnerPageDiscussionCount', [],false);
//            $app->jobManager()->runUnique($jobID, 120);
        }
        
        
        public static function updateBrandsDiscussionCount()
        {   
            $app = \XF::app();
            
            $sql = "SELECT brand_id, SUM(discussion_count) as total_discussion_count FROM `bh_item` GROUP BY brand_id";
            
            $results = $app->db()->query($sql)->fetchAll();
            
            foreach ($results as $result)
            {
                $app->db()->update('bh_brand', ['discussion_count' => $result['total_discussion_count']], 'brand_id = ?', $result['brand_id']);
            }
        }
}