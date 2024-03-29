<?php

namespace XenBulletins\BrandHub;

class Helper {

    public static function updateItemDiscussionCount($itemId, $action = 'plus', $count = 1) {
        
        $item = \XF::finder('XenBulletins\BrandHub:Item')->where('item_id', $itemId)->fetchOne();
//        var_dump($itemId);exit;
        if ($item) {
            $brand = $item->Brand;

            if ($action == 'plus') {
                $item->discussion_count += $count;
                $brand->discussion_count += $count;
            }
            if ($action == 'minus') {
                $item->discussion_count -= $count;
                $brand->discussion_count -= $count;
            }

            $item->save();
            $brand->save();
        }
    }
    
    public static function updateRatingAndReviewCount(\XenBulletins\BrandHub\Entity\ItemRating $rating, $count = 'plus') {
        $item = $rating->Item;
        if ($item) {
            $brand = $item->Brand;

            if ($count == 'plus') {
                
                $item->rating_count += 1;
                $brand->rating_count += 1;
                
                if($rating->is_review)
                {
                    $item->review_count += 1;
                    $brand->review_count += 1;
                }
            }
            if ($count == 'minus') {
                
                $item->rating_count -= 1;
                $brand->rating_count -= 1;
                
                if($rating->is_review)
                {
                    $item->review_count -= 1;
                    $brand->review_count -= 1;
                }
            }
            
            
            $self = new self;
            $itemRatingSum = $self->getItemRatingSum($item->item_id);
            $item->rating_sum = $itemRatingSum["sum"] ? $itemRatingSum["sum"] : 0;
            
            if($item->rating_count)
            {
                $item->rating_avg = round($itemRatingSum["sum"] / $item->rating_count, 1);
            }
            else
            {
                $item->rating_avg = 0;
            }
            
            $item->save();
            
            $brandRatingSum = $self->getBrandRatingSum($brand->brand_id);

            $brand->rating_sum = $brandRatingSum["sum"];
            
            if($brand->rating_count)
            {
                $brand->rating_avg = round($brandRatingSum["sum"] / $brand->rating_count, 1);
            }
            else
            {
                $brand->rating_avg = 0;
            }
            
            $brand->save();
        }
    }
    
    protected function getItemRatingSum($itemId)
    {
        $itemRatingSum = \xf::db()->fetchRow("
			SELECT SUM(rating) AS sum
			FROM bh_item_rating
			WHERE item_id = ?
				AND rating_state = 'visible'
		", $itemId);
        
        return $itemRatingSum;
    }
    
    protected function getBrandRatingSum($brandId)
    {
        $brandRatingSum = \xf::db()->fetchRow("
			SELECT SUM(rating_sum) AS sum
			FROM bh_item
			WHERE brand_id = ?
				AND item_state = 'visible'
		", $brandId);
        
        return $brandRatingSum;
    }
    
  

    public static function updateItemNotificiation($title, $link, $detail, $reciver) {


//        $visitor = \XF::visitor();
        $status = "display";

        $alertRepo = \XF::app()->repository('XF:UserAlert');


        $alerted = $alertRepo->alert(
                $reciver,
                1,
                "admin",
                'bh_item',
                1,
                $status,
                [
                    'title' => $title,
                    'detail' => $detail,
                    'link' => $link
                ],
                ['autoRead' => true]
        );
    }

    public static function updatePageNotificiation($title, $link, $detail, $reciver) {


//        $visitor = \XF::visitor();
        $status = "display";

        $alertRepo = \XF::app()->repository('XF:UserAlert');

        $alerted = $alertRepo->alert(
                $reciver,
                 1,
                "admin",
                'bh_ownerpage',
                1,
                $status,
                [
                    'title' => $title,
                    'detail' => $detail,
                    'link' => $link
                ],
                ['autoRead' => true]
        );
    }
    
    
    public static function updateOwnerPageDiscussionCount($itemId, $userId, $count = 'plus') {
        
        $ownerPage = \XF::finder('XenBulletins\BrandHub:OwnerPage')->where('item_id', $itemId)->where('user_id', $userId)->fetchOne();
        if($ownerPage)
        {
            if ($count == 'plus') {
                 $ownerPage->discussion_count += 1;
            }
            if ($count == 'minus') {
                 $ownerPage->discussion_count -= 1;
            }
           
            $ownerPage->save();
        }
    
    }
    
    
    public static function updateAddonOptions()
    {
        $app = \XF::app();
        
        $addonMainRoute = $app->em()->findOne('XF:Route', ['route_prefix' => 'bh-brands', 'sub_name' => '' , 'addon_id' => 'XenBulletins/BrandHub', 'route_type' => 'public']);
                
        if($addonMainRoute)
        {
            $mainRouteId = $addonMainRoute->route_id;
            $mainRoutePrefix = $addonMainRoute->route_prefix;

            \XF::repository('XF:Option')->updateOptions(['bh_main_route' => $mainRoutePrefix,'bh_main_route_id' => $mainRouteId]);
        }
    }
    
    
    // update OwnerPage Count of item and as well as brand
    public static function updateOwnerCount(\XenBulletins\BrandHub\Entity\Item $item, $count = 'added')
    {
//        $app = \XF::app();
//
//        $Item = \XF::finder('XenBulletins\BrandHub:Item')->where('item_id', $itemId)->fetchOne();
//        var_dump($itemId);exit;
        

        $brand = $item->Brand;

        if ($count == 'added') 
        {
            $item->owner_count += 1;
            $brand->owner_count += 1;
        }
        if ($count == 'removed') 
        {
            $item->owner_count -= 1;
            $brand->owner_count -= 1;
        }

        $item->save();
        $brand->save();
        
    }

}