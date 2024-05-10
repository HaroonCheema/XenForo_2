<?php

namespace XenBulletins\BrandHub\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread {

//    public function actionEdit(ParameterBag $params) { 
//        $visitor = \xf::visitor();
//        $parent = parent::actionEdit($params);
//        if(!$visitor->hasPermission('bh_brand_hub', 'bh_can_assignThreadsToHub'))
//        {
//            return $parent;
//        }
//        
//        if ($parent instanceof \XF\Mvc\Reply\View && !$this->isPost()) 
//        {            
//            $forum = $parent->getParam('forum');
//
//            if($forum && $forum->brand_id)
//            {
//                $defaultOrder = $this->options()->bh_dropdownItemListDefaultOrder ?: 'item_title';
//                $defaultDir =   'DESC';
//                
//                $items = $this->Finder('XenBulletins\BrandHub:Item')->where('brand_id', $forum->brand_id)->order($defaultOrder,$defaultDir)->fetch();
//                 
//                $parent->setParam('items', $items);
//            }     
//
//        }
//
//        return $parent;
//    }
    
    

//    protected function setupThreadEdit(\XF\Entity\Thread $thread) {
//        
//        $alreadyItemId = $thread->item_id;
//        
//        $itemId = $this->filter('item_id' , 'UINT');    
//        
//        $thread->item_id = $itemId;
////        $thread->save();
//        
//        if($itemId!=$alreadyItemId){
//            
//       $itemUpdate = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $itemId)->fetchOne();
//
//            if($itemUpdate)
//            {
//
//                  $requests = $this->finder('XenBulletins\BrandHub:ItemSub')->where('item_id', $alreadyItemId)->with(['User', 'Item'])->fetch();
//
//                   $detail="new thread ".$thread->title;
//
//                    foreach ($requests as $request) {
//
//                       $link = $this->app->router('public')->buildLink('threads', $thread);
//
//                       \XenBulletins\BrandHub\Helper::updateItemNotificiation($itemUpdate->item_title, $link, $detail, $request->User);
//                   }
//            }
//
//      }
//         
//      if($itemId != $alreadyItemId)
//      {
//            if(!$alreadyItemId && $itemId)
//            {
//                \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($itemId,'plus');
//            }
//
//            else if($alreadyItemId && !$itemId)
//            {
//                \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($alreadyItemId,'minus');
//            }
//
//            else if ($itemId && $alreadyItemId)
//            {
//                \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($alreadyItemId,'minus');               
//                \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($itemId,'plus');
//            }
//      }
//       
//        return parent::setupThreadEdit($thread);
//    }
    
    
    
    
    
    //*****************Edit Item-thread Description***************************************
       
        public function descriptionAddEdit(\XF\Entity\Thread $thread)
        {
            $viewParams = [
                'thread' => $thread
            ];

            return $this->view('XF:Thread', 'bh_thread_description_edit', $viewParams);
        }

        public function actionEditDescription(ParameterBag $params)
        {
         
           $visitor = \XF::visitor();
           if(!$visitor->hasPermission('bh_brand_hub', 'bh_canEditDiscussionDesc'))
           {
               throw $this->exception($this->noPermission());
           }
            
            $thread = $this->assertViewableThread($params->thread_id);

            return $this->descriptionAddEdit($thread);
        }
        
        public function actionSaveDescription(ParameterBag $params)
        {
            $this->assertPostOnly();
             
            $message = $this->plugin('XF:Editor')->fromInput('thread_description');
            
            $thread = $this->assertViewableThread($params->thread_id);
            $thread->fastUpdate('thread_description',$message);
            
            $item = $this->em()->find('XenBulletins\BrandHub:Item',$thread->item_id);
            
            return $this->redirect($this->buildLink(\XF::options()->bh_main_route.'/item',$item));
        }
        
//        public function actionSave(ParameterBag $params)
//	{   
//            $this->assertPostOnly();
//
//            if ($params->brand_id)
//            {
//                $brand = $this->assertBrandExists($params->brand_id);
//            }
//            else
//            {
//                $brand = $this->em()->create('XenBulletins\BrandHub:Brand');
//            }
//            
//            $descEntity = $this->saveDescription($brand);
//
//            return $this->redirect($this->buildLink(\XF::options()->bh_main_route, $brand));
//	}
        
        
//        protected function assertThreadExists($id, $with = null, $phraseKey = null)
//        {
//                return $this->assertRecordExists('XF:Thread', $id, $with, $phraseKey);
//        }
        
//*********************************************************************************
    
    

}
