<?php

namespace XenBulletins\BrandHub\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;


class RebuildReviews extends AbstractController
{
    
        protected function preDispatchController($action, ParameterBag $params)
        {
                $this->assertAdminPermission('brandhub');
        }
   
        
        public function actionIndex()
        {
             $viewParams=['success'=>false];

             return $this->view('XenBulletins\BrandHub:RebuildReviews', 'bh_rebuild_reviews', $viewParams);
        }
        
        
        public function actionRebuildStats()
        {
            
            $this->setReviewStatsToZero();   // Set items and brands Review/Rating stats to zero before rebuild
                       
            $itemIds = $this->rebuildItemsReviewStats(); // Update item's review/Rating stats
            
            if($itemIds)
            {
               $this->rebuildBrandsReviewStats($itemIds); // Update brand's review/Rating stats (overall)
            }        

            $viewParams = [

                'success'=> true,
                'message' => "The review/rating stats have been rebuilt successfully.",
            ];

            return $this->view('XenBulletins\BrandHub:RebuildReviews', 'bh_rebuild_reviews', $viewParams);
        }
        
       
        
        
        protected function setReviewStatsToZero()
        {
            $db = \XF::db();
            
            $itemQuery = "UPDATE bh_item SET rating_count = 0, review_count = 0, rating_sum = 0,rating_avg = 0";
            $brandQuery = "UPDATE bh_brand SET rating_count = 0, review_count = 0, rating_sum = 0,rating_avg = 0";
            
            $db->query($itemQuery);
            $db->query($brandQuery);
        }
        
        
        
        protected function rebuildItemsReviewStats()
        {
            $db = \XF::db();
            
            $query = "SELECT
                        item_id,
                        COUNT(*) AS total,
                        SUM(rating) AS ratingSum,
                        ROUND(SUM(rating) / COUNT(*), 1) AS ratingAvg
                    FROM
                        bh_item_rating
                    WHERE
                         rating_state = 'visible'
                    GROUP BY
                        item_id";
            
            $itemRatings = $db->fetchAll($query);
            
            if(!$itemRatings)
            {
                return null;
            }
            
            // update item's review/Rating stats
            foreach($itemRatings as $itemRating)
            { 
                $updateQuery = "UPDATE bh_item SET rating_count = ".$itemRating['total'].","
                                                . " review_count = ".$itemRating['total'].","
                                                . " rating_sum = ".$itemRating['ratingSum'].","
                                                . " rating_avg = ".$itemRating['ratingAvg'].""
                                                . " WHERE item_id = ".$itemRating['item_id'];
                
                $db->query($updateQuery);
            }
            
            $itemIds = array_column($itemRatings, 'item_id');
            
            return $itemIds;
            
        }
        
        
        
        
        protected function rebuildBrandsReviewStats($itemIds)
        {
            $db = \XF::db();
             
            $query = "SELECT
                        brand_id,
                        SUM(rating_count) AS ratingCount,
                        SUM(rating_sum) AS ratingSum,
                        ROUND(SUM(rating_sum) / SUM(rating_count), 1) AS ratingAvg
                    FROM
                        bh_item
                    WHERE
                         item_state = 'visible' and item_id IN (".$db->quote($itemIds).")
                    GROUP BY
                        brand_id";
            
            $brandRatings = $db->fetchAll($query);
            
            // update brand's review/Rating stats
            foreach($brandRatings as $brandRating)
            { 
                $updateQuery = "UPDATE bh_brand SET rating_count = ".$brandRating['ratingCount'].","
                                                . " review_count = ".$brandRating['ratingCount'].","
                                                . " rating_sum = ".$brandRating['ratingSum'].","
                                                . " rating_avg = ".$brandRating['ratingAvg'].""
                                                . " WHERE brand_id = ".$brandRating['brand_id'];
                
                $db->query($updateQuery);
            }   
            
        }

}