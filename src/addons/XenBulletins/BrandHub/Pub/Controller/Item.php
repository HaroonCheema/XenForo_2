<?php

namespace XenBulletins\BrandHub\Pub\Controller;

use XF\Pub\Controller\AbstractController;
use XenBulletins\BrandHub\Entity;
use XF\Mvc\ParameterBag;


class Item extends AbstractController
{
     
    protected function preDispatchController($action, ParameterBag $params) 
    {
        if ($action == 'Itemsub' || $action == 'Rate')
        {
            $this->assertLoggedIn();
        }
        
    }
    
    
    protected function fetchAttachment($itemId, $mainPhoto = false)
    {
//        $attachRepo = $this->repository('XF:Attachment');
        
        $finder = $this->finder('XF:Attachment')
            ->where('content_id', $itemId)
            ->where('content_type', 'bh_item');
            

        if ($mainPhoto) 
        {
            $finder->where('item_main_photo', 1);
        }

        return $finder->order('attach_date', 'DESC')->fetchOne();
    } 
    
   
    
        public function actionIndex(ParameterBag $params) {
        
        
        $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $params->item_id)->with(['Description','Category','Attachment'])->fetchOne();
        
        if (!$item)
        {
                throw $this->exception($this->notFound(\XF::phrase('bh_requested_item_not_found')));
        }
        
        
        $defaultOrderAndDir = explode(',' , $this->options()->bh_ownerPageDefaultOrder);
                        
        $defaultOrder = $defaultOrderAndDir[0];
        $defaultDir =   $defaultOrderAndDir[1];
        
        $itemPages = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('item_id', $params->item_id)->order($defaultOrder, $defaultDir)->fetch(10);
        
        $userItemPage = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('item_id', $params->item_id)->where('user_id', \XF::visitor()->user_id)->fetchOne();
              
        
        //----------------- view log ----------------------
        $isPrefetchRequest = $this->request->isPrefetch();

        if (!$isPrefetchRequest)
        {
            $itemRepo = $this->repository('XenBulletins\BrandHub:Item');
            $brandRepo = $this->repository('XenBulletins\BrandHub:Brand');

            // ToDo: these following two queries takes some time, take action no these to reduce load time
            $itemRepo->logItemView($item);
            $brandRepo->logBrandView($item->Brand);
        }
        
        
        //------------------------------------- item Attachments -------------------------------------
 
        $attachment_id = $this->filter('attachment_id', 'STR');
        $filmStripPlugin = $this->plugin('XenBulletins\BrandHub:FilmStrip');
        
        
        if ($attachment_id) 
        {
            $attachmentItem = $this->assertViewableAttachmentItem($attachment_id);
        } 
        else 
        {
            $mainPhotoAttachment = $this->fetchAttachment($item->item_id, true);  // Fetch the main photo attachment data
            //
            // If no main photo is found, fetch latest attachment
            if (!$mainPhotoAttachment) 
            {
                $mainPhotoAttachment = $this->fetchAttachment($item->item_id);
            }
        
            $attachmentItem = $mainPhotoAttachment;
        }
        
        
        if($attachmentItem)
        {
            $filmStripPluginlist = $filmStripPlugin->getFilmStripParamsForView($attachmentItem);
        }
        
        //----------------------------------------------------------------------------------------------
        
        
        
        $discussions = $this->finder('XF:Thread')->where('item_id', $params->item_id)->where('discussion_state','visible')->order('thread_id','DESC')->fetch(\xf::options()->bh_discussions_on_item);
        
        $alreadySub = $this->finder('XenBulletins\BrandHub:ItemSub')->where('item_id',$params->item_id)->where('user_id',\XF::visitor()->user_id)->fetchOne();
        
        
        // ------------- rating and reviews ------------------------------
        $visitorId = \Xf::visitor()->user_id;

        $itemReviews = $this->em()->getEmptyCollection();
	
//        $recentReviewsMax = $this->options()->bh_RecentReviewsCount;
//        if ($recentReviewsMax)
//        {
//                $ratingRepo = $this->repository('XenBulletins\BrandHub:ItemRating');
//                $itemReviews = $ratingRepo->findReviewsInItem($item)->where('user_id', '!=', $visitorId)->fetch($recentReviewsMax);
//        }
        
        
        $page = max(1, $this->filterPage());
        $perPage = $this->options()->bh_ReviewsPerPage;
         
        

        $ratingRepo = $this->repository('XenBulletins\BrandHub:ItemRating');
        $itemReviews = $ratingRepo->findReviewsInItem($item)->with('User')->where('user_id', '!=', $visitorId);

        $total = $itemReviews->total();             
        $this->assertValidPage($page, $perPage, $total, \XF::options()->bh_main_route.'/item/reviews');
        $itemReviews = $itemReviews->limitByPage($page, $perPage);
        
        
        // --------------- filter ----------------------
        $filters = $this->getFilterInput();

        if($filters)
            $itemReviews->order($filters['order'], $filters['direction']);
        else
        {
            $defaultOrderAndDir = explode(',' , $this->options()->bh_reviewsDefaultOrder);

            $defaultOrder = $defaultOrderAndDir[0];
            $defaultDir =   $defaultOrderAndDir[1];

            $itemReviews->order($defaultOrder, $defaultDir);
        }
        //--------------------------------------------
        
        $itemReviews = $itemReviews->fetch();
        
        $visitorReview = $ratingRepo->findReviewsInItem($item)->with('User')->where('user_id', $visitorId)->fetchOne();
		
        
        
//        $itemRatings = $this->finder('XenBulletins\BrandHub:ItemRating')->where('item_id', $params->item_id)->fetch()->groupBy('rating');
//         krsort($itemRatings);
         

         
        $itemRatings = [];
        for($i=5; $i > 0; $i--)
        {
             $itemRating = $this->finder('XenBulletins\BrandHub:ItemRating')->where('item_id', $params->item_id)->where('rating_state','visible')->where('rating',$i)->fetch();
             if($item->rating_count)
             {
                $itemRatings[$i] = round((count($itemRating)/$item->rating_count) * 100);
             }
             else
             {
                 $itemRatings[$i] = 0;
             }
        }
        
 
        $itemPosition = $this->getRankRecord($item,$item->Category->category_id);
                
       
     
        $viewParams = [
            'filmStripParams' => $filmStripPluginlist,
            'mainItem' => $attachmentItem,
            'item' => $item,
            
            'itemReviews' => $itemReviews,
            'itemRatings' => $itemRatings,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'filters' => $filters,
            
            'discussions' => $discussions,
            'itemPages'=>$itemPages,
            'userItemPage' => $userItemPage,
            'ownerPageTotal' => count($itemPages),
            'alreadySub'=>$alreadySub,
            'itemPosition' => $itemPosition,
            'visitorReview' => $visitorReview
        ];
        return $this->view('XenBulletins\BrandHub:Brand', 'bh_item_detail', $viewParams);
    }
    
        protected function assertViewableAttachmentItem($attachmentId)
	{
    
	
		$attachmentitem = $this->em()->find('XF:Attachment', $attachmentId);

		if (!$attachmentitem)
		{
			throw $this->exception($this->notFound(\XF::phrase('bh_requested_media_item_not_found')));
		}


		return $attachmentitem;
	}
        
        
        
        
        
        protected function assertViewableItem($itemId)
	{
		$item = $this->em()->find('XenBulletins\BrandHub:Item', $itemId);

		if (!$item)
		{
			throw $this->exception($this->notFound(\XF::phrase('bh_requested_item_not_found')));
		}

		return $item;
	}
        
        
        public function actionReviews(ParameterBag $params)
	{

//            echo '<<pre>';
//            var_dump($params);exit;
		$item = $this->assertViewableItem($params->item_id);


		$page = $this->filterPage();
		$perPage = $this->options()->bh_ReviewsPerPage;

		$ratingRepo = $this->repository('XenBulletins\BrandHub:ItemRating');
		$itemReviews = $ratingRepo->findReviewsInItem($item);
                
                // --------- Quick filter ---------------
                $filter = $this->filter('_xfFilter', [
                        'text' => 'str',
                        'prefix' => 'bool'
                ]);

                if (strlen($filter['text']))
                {
                    $itemReviews->where('message', 'LIKE', $itemReviews->escapeLike($filter['text'], $filter['prefix'] ? '?%' : '%?%'));
                }
                // ---------------------------------
            
                
                $total = $itemReviews->total();             
		$this->assertValidPage($page, $perPage, $total, \XF::options()->bh_main_route.'/item/reviews');
		$itemReviews->limitByPage($page, $perPage);
                
                // --------------- filter ----------------------
                $filters = $this->getFilterInput();
            
                if($filters)
                    $itemReviews->order($filters['order'], $filters['direction']);
                else
                {
                    $defaultOrderAndDir = explode(',' , $this->options()->bh_reviewsDefaultOrder);
                        
                    $defaultOrder = $defaultOrderAndDir[0];
                    $defaultDir =   $defaultOrderAndDir[1];

                    $itemReviews->order($defaultOrder, $defaultDir);
                }
                //--------------------------------------------
                
		$itemReviews = $itemReviews->fetch();
                
                
//                echo '<pre>';
//                var_dump($itemReviews);exit;

		/** @var \XF\Repository\UserAlert $userAlertRepo */
//		$userAlertRepo = $this->repository('XF:UserAlert');
//		$userAlertRepo->markUserAlertsReadForContent('resource_rating', $reviews->keys());

		$viewParams = [
			'item' => $item,
			'itemReviews' => $itemReviews,

			'page' => $page,
			'perPage' => $perPage,
			'total' => $total,
                        'filters' => $filters
		];
		return $this->view('XenBulletins\BrandHub:Item\Reviews', 'bh_item_reviews', $viewParams);
	}
        
        
        protected function setupItemRate(\XenBulletins\BrandHub\Entity\Item $item)
	{

		$rater = $this->service('XenBulletins\BrandHub:Item\Rate', $item);

		$input = $this->filter([
			'rating' => 'uint',
			'is_anonymous' => 'bool'
		]);
                
                 $message = $this->plugin('XF:Editor')->fromInput('message');

		$rater->setRating($input['rating'], $message);


		return $rater;
	}

	public function actionRate(ParameterBag $params)
	{

		$visitorUserId = \XF::visitor()->user_id;

		$item = $this->assertViewableItem($params->item_id);

		if (!$item->canRate($error))
		{
			return $this->noPermission($error);
		}

		$existingRating = $item->ItemRatings[$visitorUserId];
                
		if ($existingRating && !$existingRating->canUpdate($error))
		{
			return $this->noPermission($error);
		}

		if ($this->isPost())
		{
			$rater = $this->setupItemRate($item);
			$rater->checkForSpam();

			if (!$rater->validate($errors))
			{
				return $this->error($errors);
			}
                        
                        $hash = $this->filter('attachment_hash', 'str');
                        
                        if($existingRating)
                        {
                            $sql = "Update xf_attachment set content_id = 0, temp_hash = '$hash' where content_id='$existingRating->item_rating_id' and content_type = 'bh_review'";
                            \XF::db()->query($sql);
                        }

			$rating = $rater->save();
//                                        echo 'dd';exit;
                        $inserter = $this->service('XF:Attachment\Preparer');
                        $associated = $inserter->associateAttachmentsWithContent($hash, 'bh_review', $rating->item_rating_id);

                        
                        $itemReview = $this->finder('XenBulletins\BrandHub:ItemRating')->where('item_id',$params->item_id)->where('user_id',$visitorUserId)->fetchOne();
                    
                        //--------
                        
                         $viewParams = [
                            'item' => $item,
                            'itemReview' => $itemReview,
//                            'userItemPage' => $userItemPage
                        ];
                         
//                        $this->setResponseType('json');
                         
//                        $reply = $this->view('XenBulletins\BrandHub:ItemReview', '', $viewParams);
//                        $reply->setJsonParam('message', \XF::phrase('your_changes_have_been_saved'));
//                        return $reply;
                        
                        
                        $reply = $this->view('XenBulletins\BrandHub:Item', 'bh_list_review', $viewParams);
                        $reply->setJsonParam('message', \XF::phrase('your_changes_have_been_saved'));
                        return $reply;

//                        return $this->view('XenBulletins\BrandHub:Item', 'bh_quick_review_content', $viewParams);

                        //--------
//                        $dynamicRedirect = $this->getDynamicRedirect();
                        

//                        return $this->redirect($this->getDynamicRedirect().'#reviews');
//			return $this->redirect($this->buildLink(\XF::options()->bh_main_route.'/item/#reviews',$item));
		}
		else
		{
                    
                    $attachmentRepo = $this->repository('XF:Attachment');
                    $attachmentData = $attachmentRepo->getEditorData('bh_review',$existingRating);
                    
			$viewParams = [
				'item' => $item,
				'existingRating' => $existingRating,
                                'attachmentData' => $attachmentData
			];
			return $this->view('XenBulletins\BrandHub:Item\Rate', 'bh_item_rate', $viewParams);
		}
	}
        
        
        
        public  function actionItemSub(ParameterBag $params){
          
          $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $params->item_id)->fetchOne();
 
             $visitor = \XF::visitor();
             
          
               
            $itemSub = $this->em()->create('XenBulletins\BrandHub:ItemSub');
         
            $itemSub->user_id = $visitor->user_id;
            $itemSub->item_id = $params->item_id;
            $itemSub->save();
            
           return $this->redirect($this->buildLink(\XF::options()->bh_main_route.'/item',$item));
        
        
        
        
    }
    
    
    public function getRankRecord($item,$category_id) 
    {
        $ItemPosition = [];

                 
        $ItemPosition['categoryItemDiscussionPosition'] = $this->categoryItemDiscussionPosition($item,$category_id);
        $ItemPosition['overallItemDiscussionPosition'] = $this->overallItemDiscussionPosition($item);

        $ItemPosition['categoryItemViewPosition'] = $this->categoryItemViewPosition($item,$category_id);

        $ItemPosition['overallItemViewPosition'] = $this->overallItemViewPosition($item);


     
        $ItemPosition['categoryItemReviewPosition'] = $this->categoryItemReviewPosition($item,$category_id);
        $ItemPosition['overallItemReviewPosition'] = $this->overallItemReviewPosition($item);


        $ItemPosition['totalcategoryItems'] = $this->totalcategoryItems($category_id);
        $ItemPosition['totalItems'] = $this->totalItems();
         
        $ItemPosition['itemOwnerPageRanking'] = $this->getItemOwnerPageRanking($item);

    
        return $ItemPosition;
    }
    
    public function getItemOwnerPageRanking($item)
    {
        $sql = 'Select item_id, rank() over (order by owner_count desc) as position from bh_item';
        
        return $this->itemRankPosition($sql,$item);
    }
    
    
    public  function totalcategoryItems($category_id)
    {     
        $sql = "Select COUNT(*) as total from bh_item  where category_id='$category_id';";
        
        $db = \XF::db();
        $totalItems = $db->fetchOne($sql);

        return $totalItems;
    }
    
    public  function totalItems()
    {
        $sql = "Select COUNT(*) as total from bh_item;";
      
        $db = \XF::db();
        $totalItems = $db->fetchOne($sql);

        return $totalItems;
    }

    public function categoryItemDiscussionPosition($item,$category_id)
    {    
        $sql = "Select item_id, rank() over (order by discussion_count desc) as position  from bh_item  where category_id='$category_id';";
        
        return $this->itemRankPosition($sql,$item); 
    }
    
    public function overallItemDiscussionPosition($item)
    {    
        $sql = "Select item_id, rank() over (order by discussion_count desc) as position from bh_item;";
        
        return $this->itemRankPosition($sql,$item);
    }
    
    public function categoryItemViewPosition($item,$category_id)
    {    
        $sql = "Select item_id, rank() over (order by view_count desc) as position  from bh_item  where category_id='$category_id';";
        
        return $this->itemRankPosition($sql,$item);
    }
    
    public function overallItemViewPosition($item)
    {
        $sql = "Select item_id, rank() over (order by view_count desc) as position from bh_item;";
        
        return $this->itemRankPosition($sql,$item);
    }
    
    public  function categoryItemReviewPosition($item,$category_id)
    {    
        $sql = "Select item_id, rank() over (order by rating_avg desc) as position  from bh_item  where category_id='$category_id';";
        
        return $this->itemRankPosition($sql,$item);
    }
  
    public  function overallItemReviewPosition($item)
    {    
        $sql = "Select item_id, rank() over (order by rating_avg desc) as position from bh_item;";

        return $this->itemRankPosition($sql,$item);
    }
   
     
    public function itemRankPosition($sql, $item) 
    {
        
        $db = \XF::db();
        $result = $db->fetchPairs($sql);
        
        if(array_key_exists($item->item_id, $result))
        {
            return $result[$item->item_id];
        }      
        else
        {
            return 0;
        }
                 
//        foreach ($records as $record) {
//
//            if($item->item_id == $record['item_id']) {
//
//               return $record['position'];
//            
//            }
//        }
      
    }
    
    
      public  function actionitemThreads(ParameterBag $params){
        
        
       $threads = $this->finder('XF:Thread')->where('item_id', $params->item_id)->where('discussion_state','visible')->order('thread_id','DESC')->fetch();
        
        $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $params->item_id)->fetchOne();
        
        $viewParams = [
            'threads' => $threads,
            'item'=> $item,
        
        ];
        
     return $this->view('XenBulletins\BrandHub:Brand', 'item_thread_lists', $viewParams);
        
        
    }
    
    
     public function actionFilmStripJump(ParameterBag $params) {

          
        $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $params->item_id)->fetchOne();

        $direction = $this->filter('direction', 'str');
        $jumpFromId = $this->filter('attachment_id', 'uint');

        $jumpFrom = $this->finder('XF:Attachment')->where('attachment_id', $jumpFromId)->fetchOne();

        if(!$jumpFrom)
        {
            throw $this->exception($this->notFound(\XF::phrase('bh_requested_item_not_found')));
        }

        $filmStripPlugin = $this->plugin('XenBulletins\BrandHub:FilmStrip');

        $filmStripParams = $filmStripPlugin->getFilmStripParamsForJump($jumpFrom, $direction);

        $viewParams = [
            'item' => $item,
            'filmStripParams' => $filmStripParams
        ];

        return $this->view('XenBulletins\BrandHub:Item', 'bh_item_detail', $viewParams);
    }
    
    
    //*************************Edit item description***************************
    
      public function itemAddEdit($item) {

            $attachmentRepo = $this->repository('XF:Attachment');
        $attachmentData = $attachmentRepo->getEditorData('bh_item', $item);
      
        $attachmentData["attachments"] = null;
        $viewParams = [
            'item' => $item,
            'attachmentData'=>$attachmentData,
        ];

        return $this->view('XenBulletins\BrandHub:Item', 'bh_item_description_edit', $viewParams);
    }
    
    public function actionQuickDelete(ParameterBag $params)
    {
        $this->assertPostOnly();
        
        if (!$params->item_id)
        {  
            return $this->redirect($this->getDynamicRedirect());
        }

        $threadIds = $this->filter('thread_ids', 'array-uint');
        
        if (empty($threadIds))
        {   
            return $this->redirect($this->getDynamicRedirect());
        }
        
        $discussions = $this->finder('XF:Thread')->where('thread_id',$threadIds)->fetch();

        if ($this->isPost() && !$this->filter('quickdelete', 'bool'))
        {
            // unassign (remove) items from threads
            $db = \XF::db();
            $threadIdsQuoted = $db->quote($threadIds);
            
            $db->update('xf_thread', ['item_id' => 0], 'thread_id IN ('. $threadIdsQuoted . ')');
            \XenBulletins\BrandHub\Helper::updateItemDiscussionCount($params->item_id,'minus', count($threadIds)); 

            return $this->redirect($this->getDynamicRedirect());
        }
        else
        {
            $item = $this->assertItemExists($params->item_id);
            
            $viewParams = [
                
                'item' => $item,
                'discussions' => $discussions
            ];

            return $this->view('XenBulletins\BrandHub:Item', 'bh_discussions_quick_remove_editor', $viewParams);
        }

    }
        

    public function actionEdit(ParameterBag $params) {

        $visitor = \XF::visitor();
        if(!$visitor->hasPermission('bh_brand_hub', 'bh_can_edit_itemDescript'))
        {
            throw $this->exception($this->noPermission());
        }
                   
        $item = $this->assertItemExists($params->item_id, 'Description');

        return $this->itemAddEdit($item);
    }
    
    
    protected function saveDescription(\XenBulletins\BrandHub\Entity\Item $item) {
        $message = $this->plugin('XF:Editor')->fromInput('description');
        
           if ($item->Description && strcmp($message, $item->Description->description)) {

               
                $detail = " Description";
                $this->descriptionitemNotify($item,$detail);
            }


        $descEntity = $this->finder('XenBulletins\BrandHub:ItemDescription')->where('item_id', $item->item_id)->fetchOne();
        if (!$descEntity) {
            $descEntity = $this->em()->create('XenBulletins\BrandHub:ItemDescription');
        }

        $descEntity->description = $message;
        $descEntity->item_id = $item->item_id;
        $descEntity->save();

        return $descEntity;
    }
    
    
     public function descriptionitemNotify($item,$detail){
        
          $requests = $this->finder('XenBulletins\BrandHub:ItemSub')->where('item_id', $item->item_id)->with(['User', 'Item'])->fetch();
      
            if ($detail != '') {
                
                foreach ($requests as $request) {

                    $link = $this->app->router('public')->buildLink(\XF::options()->bh_main_route.'/item', $request->Item);
                  
 
                    \XenBulletins\BrandHub\Helper::updateItemNotificiation($request->Item->item_title, $link, $detail, $request->User);
                }
            }
        
    }
    
    
    
     public function actionSave(ParameterBag $params) {

        $this->assertPostOnly();

        if ($params->item_id) {
            $item = $this->assertItemExists($params->item_id);
        } else {
            $item = $this->em()->create('XenBulletins\BrandHub:Item');
        }

        $descEntity = $this->saveDescription($item);


        $item->save();
        
         $hash = $this->filter('attachment_hash', 'str');
        $sql = "Update xf_attachment set content_id=$item->item_id where temp_hash='$hash'";
        $db = \XF::db();
        $db->query($sql);
        
          $attachments = $this->finder('XF:Attachment')->where('temp_hash', $hash)->fetch();
        foreach ($attachments as $attachment) {
            $attachment->temp_hash = '';
            $attachment->unassociated = 0;
            $attachment->save();
        }

        return $this->redirect($this->buildLink(\XF::options()->bh_main_route.'/item', $item));
    }
    
    
    protected function assertItemExists($id, $with = null, $phraseKey = null) {
        return $this->assertRecordExists('XenBulletins\BrandHub:Item', $id, $with, $phraseKey);
    }

//*********************************************************************************
    
    
    
  public function actionUploadPhoto(ParameterBag $params)
    {
        if (!\xf::visitor()->hasPermission('bh_brand_hub', 'bh_canUploadPhotos'))
        {
                return $this->noPermission();
        }
        

         $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $params->item_id)->fetchOne();
         $brandId = $item->Brand->brand_id; 

        $items = $this->Finder('XenBulletins\BrandHub:Item')->where('brand_id', $brandId)->order('item_id', 'DESC')->fetch();



        $attachmentRepo = $this->repository('XF:Attachment');
        $attachmentData = $attachmentRepo->getEditorData('bh_item', $item);
        
        $attchmentTime=$attachmentData['attachments'] ? end($attachmentData['attachments'])->attach_date : '';
       $attachmentData["attachments"] = null;
        

        $viewParams = [
            'attachment_time' => $attchmentTime,
            'selectedItem' => $item,
            'items' => $items,
            'attachmentData' => $attachmentData,
        ];

//            var_dump($viewParams);exit;

        return $this->view('XenBulletins\BrandHub:Item', 'bh_uploadPhoto', $viewParams);
    }
    
    public function actionSavePhoto()
    {
        $userId = \xf::visitor()->user_id;
        
        $itemId = $this->filter('item_id','UINT');
        $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $itemId)->fetchOne();

        
        
        $itemPage = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('item_id', $itemId)->where('user_id', $userId)->fetchOne();
      
        $hash = $this->filter('attachment_hash', 'str');


        $sql = "Update xf_attachment set content_id=$item->item_id where temp_hash='$hash'";
        $db = \XF::db();
        $db->query($sql);

        
        $attachments = $this->finder('XF:Attachment')->where('temp_hash', $hash)->fetch();
        foreach ($attachments as $attachment) {
            $attachment->temp_hash = '';
            $attachment->unassociated = 0;
            $attachment->user_id = $userId;
            $attachment->page_id = $itemPage ? $itemPage->page_id : 0;
            $attachment->save();
        }
        
             $attachmentRepo = $this->repository('XF:Attachment');
            $attachmentData = $attachmentRepo->getEditorData('bh_item', $item);
            if(count($attachmentData['attachments'])>0){
            $attachmentTime = end($attachmentData['attachments'])->attach_date;

            }
            
              if (count($attachmentData['attachments'])>0 && $attachmentTime > $this->filter('attachment_time', 'int')) {
                 $detail="";
                $detail = $detail . " New photos";
                
                $this->itemAttachmentNofity($item,$detail);
        
                if($itemPage){
                    
                $this->ownerpageAttachmentNotify($itemPage,$detail);
                }
            }
        
        return $this->redirect($this->buildLink(\XF::options()->bh_main_route.'/item', $item));
        
    }
    
    
    public function itemAttachmentNofity($item,$detail){
        
          $requests = $this->finder('XenBulletins\BrandHub:ItemSub')->where('item_id', $item->item_id)->with(['User', 'Item'])->fetch();
      
            if ($detail != '') {
                
                foreach ($requests as $request) {

                    $link = $this->app->router('public')->buildLink(\XF::options()->bh_main_route.'/item', $request->Item);
                  
 
                    \XenBulletins\BrandHub\Helper::updateItemNotificiation($request->Item->item_title, $link, $detail, $request->User);
                }
            }
        
        
    }
    
    
    public function ownerpageAttachmentNotify($itemPage,$detail) {
   
     
        $requests = $this->finder('XenBulletins\BrandHub:PageSub')->where('page_id', $itemPage->page_id)->with(['User'])->fetch();

        if ($detail != '') {


            foreach ($requests as $request) {

                $link = $this->app->router('public')->buildLink('owners', $request->Page);
              
                \XenBulletins\BrandHub\Helper::updatePageNotificiation($itemPage->Item->item_title, $link, $detail, $request->User);
            }
        }
    }

        
    public function assertLoggedIn()
    {
        if (!$this->isLoggedIn())
        {
                throw $this->exception($this->noPermission());
        }
    }
    
       public  function actionmainPhoto(ParameterBag $params){
       

      $items = $this->finder('XF:Attachment')->where('content_id', $params->item_id)->where('content_type', 'bh_item')->order('attach_date','Desc')->fetch();
      
         if(!count($items)){
          
           $phraseKey = "No photo in Item";
                                throw $this->exception(
                                        $this->notFound(\XF::phrase($phraseKey))
                                );
      }
      $selectedAttachment = $this->finder('XF:Attachment')->where('content_id', $params->item_id)->where('content_type', 'bh_item')->where('item_main_photo', 1)->order('attach_date','Desc')->fetchOne();
 
//      var_dump($selectedAttachment);exit;
      $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $params->item_id)->fetchOne();

            $viewParams = [
            'items' => $items,
             'item'=>$item,
             'selectedAttachment'=>$selectedAttachment,
        ];
            
        return $this->view('XenBulletins\BrandHub:Item', 'bh_item_main_photo', $viewParams);
       }
       
       public function actionsetMainPhoto(ParameterBag $params){
           
        $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $params->item_id)->fetchOne();
        $mainItem = $this->filter('mainitem', 'int');
       
       if($mainItem){
           
        $sql = "Update xf_attachment set item_main_photo=0 where content_id='$params->item_id'";
        $db = \XF::db();
        $db->query($sql);
        
     

         $attachment = $this->finder('XF:Attachment')->where('attachment_id', $mainItem)->fetchOne();
          
         $attachment->fastUpdate('item_main_photo',1);
                 
         $attachment->save();
           
         }
         return $this->redirect($this->buildLink(\XF::options()->bh_main_route.'/item', $item));
           
       }
       
       
       public function actionBookmark(ParameterBag $params)
	{
           if (!\xf::visitor()->hasPermission('bh_brand_hub', 'create_bookmark') || !\xf::visitor()->user_id)
             {
                 return $this->noPermission();
             }
       
		$item = $this->assertViewableItem($params->item_id);


		/* @var \XF\ControllerPlugin\Bookmark $bookmarkPlugin */
		$bookmarkPlugin = $this->plugin('XF:Bookmark');

//                var_dump($bookmarkPlugin);exit;
		return $bookmarkPlugin->actionBookmark(
			$item, $this->buildLink('bh-item/bookmark', $item)
		);
	}
        
         public function actionReact(ParameterBag $params)
	{
             if (!\xf::visitor()->hasPermission('bh_brand_hub', 'react') || !\xf::visitor()->user_id)
             {
                 return $this->noPermission();
             }
		$item = $this->assertViewableItem($params->item_id);

		$reactionPlugin = $this->plugin('XF:Reaction');
            return	 $reactionPlugin->actionReactSimple($item, 'bh-item');
                 
	}
        
        public function actionReactions(ParameterBag $params)
	{
	
            
                $item = $this->assertViewableItem($params->item_id);


		$breadcrumbs = $item->getBreadcrumbs();
             
		$title = \XF::phrase('members_who_reacted_to_message_x', ['position' => ($item->position + 1)]);
               

		/* @var \XF\ControllerPlugin\Reaction $reactionPlugin */
		$reactionPlugin = $this->plugin('XF:Reaction');
		return $reactionPlugin->actionReactions(
			$item,
			'bh-item/reactions',
			$title, $breadcrumbs
		);
	}
        
        
        
         public  function actionUnSub(ParameterBag $params){

        

          $item = $this->assertItemExists($params->item_id);
                   $viewParams = [
				'item' => $item,
				
			];
                   
		return $this->view('XenBulletins\BrandHub:Unsub', 'delete_confirm_unsub', $viewParams);
    }
    
     public  function actionUnSubItem(ParameterBag $params){
        
         
          $itemUnSub = $this->finder('XenBulletins\BrandHub:ItemSub')->where('item_id', $params->item_id)->where('user_id', \xf::visitor()->user_id)->fetchOne();
       
        if($itemUnSub->user_id != \xf::visitor()->user_id)
        {
            return $this->noPermission();
        }
             $item = $this->assertItemExists($params->item_id);

              if($itemUnSub){

                  $itemUnSub->delete();
              }

              return $this->redirect($this->getDynamicRedirect());
              
//               return $this->redirect($this->buildLink(\XF::options()->bh_main_route.'/item',$item));
        
    }
    
    
    //***************************** Reviews Filters ****************************************************
        
        
        public function actionReviewsFilters(ParameterBag $params)
	{
		$filters = $this->getFilterInput();
                
                if ($params->item_id)
                {
                    $item = $this->assertViewableItem($params->item_id);
                }
                else
                    $item = null;

		
		$viewParams = [
			'filters' => $filters,
                        'content' => $item,
                        'route' => 'bh-item/reviews',
		];
		return $this->view('XenBulletins\BrandHub:Filters', 'bh_reviews_filters', $viewParams);
	}
        
        
        
        public function getFilterInput($brand=false): array
	{
		$filters = [];

		$input = $this->filter([
			'order' => 'str',
			'direction' => 'str'
		]);

//echo '<pre>';
//var_dump($input);exit;
		$sorts = $this->getAvailableSorts();

		if ($input['order'] && isset($sorts[$input['order']]))
		{
			if (!in_array($input['direction'], ['asc', 'desc']))
			{
				$input['direction'] = 'desc';
			}

                       
                        $defaultOrderAndDir = explode(',' , $this->options()->bh_reviewsDefaultOrder);
                        
                        $defaultOrder = $defaultOrderAndDir[0];
			$defaultDir =   $defaultOrderAndDir[1];

			if ($input['order'] != $defaultOrder || $input['direction'] != $defaultDir)
			{
				$filters['order'] = $input['order'];
				$filters['direction'] = $input['direction'];
			}
		}
                
                
//echo '<pre>';
//var_dump($filters);exit;
		return $filters;
	}
        
              
        public function getAvailableSorts(): array
	{
		// maps [name of sort] => field in/relative to itemRating entity
		return [
			'rating' => 'rating',
                        'rating_date' => 'rating_date',
                        'reaction_score' => 'reaction_score',
                    
                        'page_id' => 'page_id',
                        'view_count' => 'view_count',
                        'discussion_count' => 'discussion_count',
		];
	}
        
        

}