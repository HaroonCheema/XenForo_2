<?php

namespace XenBulletins\BrandHub\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum {


//    protected function finalizeThreadCreate(\XF\Service\Thread\Creator $creator) {
//        $createThreds = parent::finalizeThreadCreate($creator);
//
//        $itemId = $this->filter('item_id', 'uint');
//        
//        $thread = $creator->getThread();
//        $thread->item_id = $itemId;
//        
//        $thread->save();
//        
//        if($itemId){
//           
//               $requests = $this->finder('XenBulletins\BrandHub:ItemSub')->where('item_id', $itemId)->with(['User', 'Item'])->fetch();
//               
//                $detail="new thread".$thread->title;
//
//                 foreach ($requests as $request) {
//
//                    $link = $this->app->router('public')->buildLink('threads', $thread);
//                  
//                    \XenBulletins\BrandHub\Helper::updateItemNotificiation($request->Item->item_title, $link, $detail, $request->User);
//                }
//            
//        }
//        
//        \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($itemId); 
//        \XenBulletins\BrandHub\Helper::updateOwnerPageDiscussionCount($itemId, $thread->user_id,'plus');
//
//        return $createThreds;
//    }

    
    
//    protected function finalizeThreadCreate(\XF\Service\Thread\Creator $creator) {
//    
//        $parent = parent::finalizeThreadCreate($creator);
//        
//        $stringTags = $this->filter('tags', 'str');
//        
//        if($stringTags)
//        {
//            $thread = $creator->getThread();
//            
//            $itemFinder = $this->finder('XenBulletins\BrandHub:Item'); 
//            
//            $tags = explode(',', $stringTags);
//           
//            $conditions = [];
//            foreach($tags as $tag)
//            {  
//                $quotedtag = $itemFinder->quote(trim($tag));
//                $conditions[] = ['tags', 'LIKE', $itemFinder->escapeLike($tag, '%?%')];
//            } 
//            
//            $items = $itemFinder->whereOr($conditions)->fetch();
//            
//            foreach($items as $item)
//            {
//                $itemId = $item->item_id;
//                $this->itemsNewThreadNotification($itemId, $thread);
//                
//                \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($itemId); 
//                \XenBulletins\BrandHub\Helper::updateOwnerPageDiscussionCount($itemId, $thread->user_id,'plus');
//            }
//             
//        }
//
//       return $parent;
//    }
    
    
//    protected function itemsNewThreadNotification($itemId, $thread)
//    {
//        $results = $this->finder('XenBulletins\BrandHub:ItemSub')->where('item_id', $itemId)->with(['User', 'Item'])->fetch();
//               
//        $detail="new thread".$thread->title;
//
//        foreach ($results as $result)     
//        {
//            $link = $this->app->router('public')->buildLink('threads', $thread);
//
//            \XenBulletins\BrandHub\Helper::updateItemNotificiation($result->Item->item_title, $link, $detail, $result->User);
//        }
//    }






    public function actionPostThread(ParameterBag $params) 
    {
 
        $parent = parent::actionPostThread($params);
        
        $itemId = $this->filter('item_id', 'uint');
        
        if ($parent instanceof \XF\Mvc\Reply\View && $itemId) 
        {
            $item = $this->em()->find('XenBulletins\BrandHub:Item', $itemId);
            
            if($item)
            {
                $parent->setParam('tags', $item->tags);
//                $parent->setParam('item', $item);
            }
        }
        
        
        return $parent;
    }
    
     public function actionForum(ParameterBag $params) {

        $forum = parent::actionForum($params);

        $brand_id = $forum->getParam('forum')->brand_id;

        $hideitemsBlock = \XF::options()->hide_forum_items;

        if ($forum instanceof \XF\Mvc\Reply\View && $brand_id && !$hideitemsBlock) {

            $limit_items = \XF::options()->forum_items_display;

            $brand = $this->finder('XenBulletins\BrandHub:Brand')->where('brand_id', $brand_id)->fetchOne();


            $itemFinder = $this->finder('XenBulletins\BrandHub:Item')->where('brand_id', $brand_id);
            
            $total = $itemFinder->total();
       
            $items = $itemFinder->order('discussion_count','DESC')->fetch($limit_items);
            
            if (count($items) > 0) {

                $forum->setParam('items', $items);
                $forum->setParam('brand', $brand);
                $forum->setParam('itemCount', $total);
            }
        }
        
        return $forum;
     }
    

}
