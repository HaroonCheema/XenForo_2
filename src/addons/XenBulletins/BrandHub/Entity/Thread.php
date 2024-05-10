<?php

namespace XenBulletins\BrandHub\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{

    protected function _postSave()
    {
            $app = \XF::app();

            $stringTags = $app->request->filter('tags', 'str'); 
            
        //-----if isInsert ---------
            if($stringTags && $this->isInsert())
            {
                $items = $this->getItemsOfTags($stringTags);   // get items against tags

                foreach($items as $item)
                {
                    $itemId = $item->item_id;
                    $this->itemsNewThreadNotification($itemId);

                    \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($itemId); 
                    \XenBulletins\BrandHub\Helper::updateOwnerPageDiscussionCount($itemId, $this->user_id,'plus');
                }
            }
            
            
            
        //-----if isUpdate ---------
            
            
            $visibilityChange = $this->isStateChanged('discussion_state', 'visible');
            
            if ($this->isUpdate())
            {
                // get tags titles
                $tags = $this->getTagsTitle();
                
                if($tags)
                {
                    $items = $this->getItemsOfTags($tags);   // get items against tags
                
                    foreach($items as $item)
                    {
                        $itemId = $item->item_id;

                        if ($visibilityChange == 'enter')
                        {                  
                                \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($itemId,'plus');
                                \XenBulletins\BrandHub\Helper::updateOwnerPageDiscussionCount($itemId, $this->user_id,'plus');
                        }
                        else if ($visibilityChange == 'leave')
                        {                 
                                \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($itemId,'minus');
                                \XenBulletins\BrandHub\Helper::updateOwnerPageDiscussionCount($itemId, $this->user_id,'minus');
                        }
                    }
                }
               
            }
            
            return parent::_postSave();
    }
    
    
    protected function getTagsTitle()
    {
        // get tags titles
        $tags = [];
        foreach($this->tags as $tag)
        {
            $tags[] = $tag["tag"];
        }
        
        return $tags;
    }

   

    protected function itemsNewThreadNotification($itemId)
    {
        $app = \XF::app();
        
        $thread = $this;
        
        $results = $app->finder('XenBulletins\BrandHub:ItemSub')->where('item_id', $itemId)->with(['User', 'Item'])->fetch();
               
        $detail="new thread".$thread->title;

        foreach ($results as $result)     
        {
            $link = $app->router('public')->buildLink('threads', $thread);

            \XenBulletins\BrandHub\Helper::updateItemNotificiation($result->Item->item_title, $link, $detail, $result->User);
        }
    }
    
    
    
    
    protected function getItemsOfTags($tags)
    {
        $app = \XF::app();
       
        $thread = $this;

        $itemFinder = $app->finder('XenBulletins\BrandHub:Item'); 

        if (is_string($tags))
        {
            $tags = explode(',', $tags);
        }


        $conditions = [];
        foreach($tags as $tag)
        {  
            $quotedtag = $itemFinder->quote(trim($tag));
            $conditions[] = ['tags', 'LIKE', $itemFinder->escapeLike($tag, '%?%')];
        } 
        
//        if(!$conditions)
//        {
//            return null;
//        }

        $items = $itemFinder->whereOr($conditions)->fetch();
        
        return $items;
    }


    
    protected function _postDelete()
    {
        // get tags titles
        $tags = $this->getTagsTitle();
                
        if($tags && ($this->discussion_state != 'deleted'))
        {                   
             $items = $this->getItemsOfTags($tags);   // get items against tags
             
            foreach($items as $item)
            {
                $itemId = $item->item_id;
             
                \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($itemId,'minus');
                \XenBulletins\BrandHub\Helper::updateOwnerPageDiscussionCount($itemId, $this->user_id,'minus');
            }
        }
        
        return parent::_postDelete();
    }

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);
        $structure->columns['item_id'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['thread_description'] =  ['type' => self::STR, 'default' => ''];

        return $structure;
    }
    
    
}