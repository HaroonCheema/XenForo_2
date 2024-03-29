<?php

namespace XenBulletins\BrandHub\Pub\Controller;

use XF\Pub\Controller\AbstractController;
use XF\Mvc\ParameterBag;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\FormAction;
use XF\Mvc\Reply\View;

class OwnerPage extends AbstractController {
    
      protected function preDispatchController($action, ParameterBag $params) {
          
        if ($action == 'Add' || $action == 'Pagesub')
        {
            $this->assertLoggedIn();
        }
        
    }
    
    
    public function actionIndex(ParameterBag $params) {
        

        if($params->page_id)
        {
            return $this->rerouteController(__CLASS__, 'page', $params);
        }
        
        

           
        $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $params->item_id)->fetchOne();
        $itemPages = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('item_id', $params->item_id);
        
        $itemPagesClone = clone $itemPages;
        
        $userItemPage = $itemPagesClone->where('user_id', \XF::visitor()->user_id)->fetchOne();

//        $type = $this->filter('type', 'str');
//        if ($type) {
//            $itemPages->order($type, 'DESC');
//            $pageSelected = $type;
//        }
//        else
//        {
////            $defaultOrderAndDir = explode(',' , $this->options()->bh_ownerPageDefaultOrder);
////                        
////                        $defaultOrder = $defaultOrderAndDir[0];
////			$defaultDir =   $defaultOrderAndDir[1];
//            $itemPages->order('page_id', 'DESC');
//            $pageSelected = 'all';
//        }
        
        
            $total = $itemPages->total();


            $filters = $this->getFilterInput();
            
            if($filters)
                $itemPages->order($filters['order'], $filters['direction']);
            else
            {
                $defaultOrderAndDir = explode(',' , $this->options()->bh_ownerPageDefaultOrder);

                $defaultOrder = $defaultOrderAndDir[0];
                $defaultDir =   $defaultOrderAndDir[1];

                $itemPages->order($defaultOrder, $defaultDir);
            }
        
        

            $viewParams = [

                'itemPages' => $itemPages->fetch(),
                'page' => $itemPages->fetchOne(),
                'ownerPageTotal' => $total,
                'userItemPage' => $userItemPage,
//                'pageSelected' => $pageSelected,
                'item' => $item,
                'filters' => $filters
            ];

            return $this->view('XenBulletins\BrandHub:OwnerPage', 'bh_item_owner_page_all', $viewParams);
            

    }
    
    
    
    
    protected function fetchAttachment($pageId, $mainPhoto = false)
    {
//        $attachRepo = $this->repository('XF:Attachment');
        
        $finder = $this->finder('XF:Attachment')
            ->where('content_type', 'bh_item')
            ->where('page_id', $pageId);

        if ($mainPhoto) 
        {
            $finder->where('page_main_photo', 1);
        }

        return $finder->order('attach_date', 'DESC')->fetchOne();
    }    
    
    
    

    public function actionPage(ParameterBag $params) 
    {
        
        $ownerPage = $this->assertOwnerpageExists($params->page_id,'Item');
//        $ownerPage = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('page_id', $params->page_id)->fetchOne();

        $ownerPage->fastUpdate('view_count', ($ownerPage->view_count + 1) );
       
        $item = $ownerPage->Item;
        
        //------------------------------------- Page Attachments -------------------------------------

        $attachment_id = $this->filter('attachment_id', 'STR');
        $filmStripPlugin = $this->plugin('XenBulletins\BrandHub:FilmStrip');

        $attachmentItem = "";
        $filmStripPluginlist = "";

        if ($attachment_id) 
        {
            $attachmentItem = $this->assertViewableAttachmentItem($attachment_id);
        } 
        else 
        {
            $mainPhotoAttachment = $this->fetchAttachment($ownerPage->page_id, true);  // Fetch the main photo attachment data
            //
            // If no main photo is found, fetch latest attachment
            if (!$mainPhotoAttachment) 
            {
                $mainPhotoAttachment = $this->fetchAttachment($ownerPage->page_id);
            }
        
            $attachmentItem = $mainPhotoAttachment;
        }
        
        
        if($attachmentItem)
        {
            $filmStripPluginlist = $filmStripPlugin->getFilmStripParamsForView($attachmentItem, $ownerPage);
        }
        
        //------------------------------------------------------------------------------------------------------
        
        
        


        $discussions = $this->finder('XF:Thread')->where('item_id', $ownerPage->item_id)->where('user_id', $ownerPage->user_id)->where('discussion_state','visible')->order('thread_id','DESC')->fetch(\xf::options()->bh_discussions_on_item);

        $alreadySub = $this->finder('XenBulletins\BrandHub:PageSub')->where('page_id', $params->page_id)->where('user_id', \XF::visitor()->user_id)->fetchOne();

        $pageRanking=$this->getRankRecord($ownerPage);
        
        $ratingRepo = $this->repository('XenBulletins\BrandHub:ItemRating');
        $itemReview = $ratingRepo->findReviewsInItem($item)->with('User')->where('user_id', $ownerPage->user_id)->fetchOne();
        
        // ------------------------------------- Owner Page Updates, Comments -----------------------------------------------------------------
        
            $this->assertNotEmbeddedImageRequest();
            
            $page = $params->page;
            $perPage = $this->options()->messagesPerPage;
        
            $this->assertCanonicalUrl($this->buildLink('owners', $ownerPage, ['page' => $page]));
            
            /** @var \XF\Repository\UserAlert $userAlertRepo */
            $userAlertRepo = $this->repository('XF:UserAlert');

            /** @var \XF\Repository\Attachment $attachmentRepo */
            $attachmentRepo = $this->repository('XF:Attachment');

            if ($ownerPage->canViewPostsOnOwnerPage())
            {
                    $ownerPagePostRepo = $this->getOwnerPagePostRepo();
                    $ownerPagePostFinder = $ownerPagePostRepo->findOwnerPagePostsOnOwnerPage($ownerPage, [
                            'allowOwnPending' => $this->hasContentPendingApproval()
                    ]);
                    $ownerPagePosts = $ownerPagePostFinder->limitByPage($page, $perPage)->fetch();

                    $attachmentRepo->addAttachmentsToContent($ownerPagePosts, 'bh_ownerPage_post');

                    $total = $ownerPagePostFinder->total();

                    $isRobot = $this->isRobot();
                    $ownerPagePosts = $ownerPagePostRepo->addCommentsToOwnerPagePosts($ownerPagePosts, $isRobot);

                    /** @var \XF\Repository\Unfurl $unfurlRepo */
                    $unfurlRepo = $this->repository('XF:Unfurl');
                    $unfurlRepo->addUnfurlsToContent($ownerPagePosts, $isRobot);

                    $commentIds = [];
                    foreach ($ownerPagePosts AS $ownerPagePost)
                    {
                            if ($ownerPagePost->LatestComments)
                            {
                                    $commentIds = array_merge($commentIds, $ownerPagePost->LatestComments->keys());
                            }
                    }

                    $userAlertRepo->markUserAlertsReadForContent('bh_ownerPage_post', $ownerPagePosts->keys());
                    $userAlertRepo->markUserAlertsReadForContent('bh_ownerPage_post_comment', $commentIds);
            }
            else
            {
                    $total = 0;
                    $ownerPagePosts = $this->em()->getEmptyCollection();
            }

            $this->assertValidPage($page, $perPage, $total, 'owners', $ownerPage);

            $visitor = \XF::visitor();
//            if ($ownerPage->user_id != $visitor->user_id)
//            {
//                    $userAlertRepo->markUserAlertsReadForContent('bh_ownerpage', $ownerPage->page_id);
//            }

            $canInlineMod = false;
            $canViewAttachments = false;
            $ownerPagePostAttachData = [];
            foreach ($ownerPagePosts AS $ownerPagePost)
            {
                    if (!$canInlineMod && $ownerPagePost->canUseInlineModeration())
                    {
                            $canInlineMod = true;
                    }
                    if (!$canViewAttachments && $ownerPagePost->canViewAttachments())
                    {
                            $canViewAttachments = true;
                    }
                    if ($ownerPagePost->canUploadAndManageAttachments())
                    {
                            $ownerPagePostAttachData[$ownerPagePost->post_id] = $attachmentRepo->getEditorData('bh_ownerPage_post_comment', $ownerPagePost);
                    }
            }

            if ($ownerPage->canUploadAndManageAttachmentsOnOwnerPage())
            {
                    $attachmentData = $attachmentRepo->getEditorData('bh_ownerPage_post', $ownerPage);
            }
            else
            {
                    $attachmentData = null;
            }
        
        // ---------------------------------------------------------------------------------------------------------------------------
        
        
        
        $viewParams = [
            'filmStripParams' => $filmStripPluginlist,
            'mainItem' => $attachmentItem,
            'ownerPage' => $ownerPage,
            'item' => $item,
            'discussions' => $discussions,
            'alreadySub' => $alreadySub,
            'pageRanking' => $pageRanking,
            'itemReview' => $itemReview,
            
            
            
            'profilePosts' => $ownerPagePosts,
            'canInlineMod' => $canInlineMod,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,

            'attachmentData' => $attachmentData,
            'canViewAttachments' => $canViewAttachments,
            'profilePostAttachData' => $ownerPagePostAttachData,
        ];
        return $this->view('XenBulletins\BrandHub:Brand', 'bh_page_detail', $viewParams);
    }
    
    
    
    
    
    
    
    protected function getOwnerPagePostRepo()
    {
            return $this->repository('XenBulletins\BrandHub:OwnerPagePost');
    }
    
    
    
//		$visitor = \XF::visitor();
//		if ($user->user_id != $visitor->user_id)
//		{
//			$userAlertRepo->markUserAlertsReadForContent('user', $visitor->user_id, 'following');
//		}
   
  
  
    public function itemAddEdit($item,$Page) {
        
        $attachmentRepo = $this->repository('XF:Attachment');
        $attachmentData = $attachmentRepo->getEditorData('bh_item', $item);
        
        
      

        
        if($Page->page_id && $attachmentData["attachments"])
        {
        
            $attachmentData["attachments"] = array_filter($attachmentData["attachments"],  
                                                    function ($attachment) use ($Page)
                                                    {   
                                                        if($attachment->page_id == $Page->page_id)
                                                        {
                                                            return true;
                                                        }

                                                        return false;

                                                    });
        }
        else 
        {
            $attachmentData["attachments"] = null;
        }
        

        if($Page->item_id){
        $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $Page->item_id)->fetchOne();
        }

        $viewParams = [
            'Page' => $Page,
//            'attachment_time' => $attachmentData['attachments'] ? end($attachmentData['attachments'])->attach_date : '',
            'item' => $item,
            'attachmentData' => $attachmentData,                    
        ];

        return $this->view('XenBulletins\BrandHub:OwnerPage', 'bh_item_page_edit', $viewParams);
    }

    public function actionEdit(ParameterBag $params) {

        $visitor = \XF::visitor();
        
        $Page = $this->assertOwnerpageExists($params->page_id, 'Detail');
        
         if(!$visitor->hasPermission('bh_brand_hub', 'bh_can_edit_ownerpage') || $visitor->user_id!=$Page->user_id)
        {
            throw $this->exception($this->noPermission());
        }

        return $this->itemAddEdit($Page->Item, $Page);
    }

    public function actionAdd(ParameterBag $params) {
      
        $item_id = $this->filter('item', 'STR');
        $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $item_id)->fetchOne();

         $page = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('item_id', $item_id)->where('user_id', \xf::visitor()->user_id)->fetchOne();
            if($page)
            {
                $phraseKey = "Owner page already Created in ".$page->Item->item_title." Item";
                            throw $this->exception(
                                    $this->notFound(\XF::phrase($phraseKey))
                            );
            }
        $itemPage = $this->em()->create('XenBulletins\BrandHub:OwnerPage');
        
        

        return $this->itemAddEdit($item, $itemPage);
    }

//************************Save category**********************************************

    protected function saveDescription(\XenBulletins\BrandHub\Entity\OwnerPage $OwnerPage) {

        $about = $this->plugin('XF:Editor')->fromInput('about');

        $attachment = $this->plugin('XF:Editor')->fromInput('attachment');
        $customizations = $this->plugin('XF:Editor')->fromInput('customizations');

        $PageDetail = $this->finder('XenBulletins\BrandHub:PageDetail')->where('page_id', $OwnerPage->page_id)->fetchOne();
        if (!$PageDetail) {
            $PageDetail = $this->em()->create('XenBulletins\BrandHub:PageDetail');
        }

        $PageDetail->about = $about;
        $PageDetail->attachment = $attachment;
        $PageDetail->customizations = $customizations;
        $PageDetail->page_id = $OwnerPage->page_id;
        $PageDetail->save();

        return $PageDetail;
    }

    protected function pageSaveProcess(\XenBulletins\BrandHub\Entity\OwnerPage $pageOwner) {
        $form = $this->formAction();

        $input = $this->filter(['item_id' => 'STR', 'title' => 'STR']);
        
        
        if ($pageOwner->isInsert()) {
                $input['user_id']=\xf::visitor()->user_id;



                $page = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('item_id', $input['item_id'])->where('user_id', \xf::visitor()->user_id)->fetchOne();
                if($page)
                {
                    $phraseKey = "Owner page already Created in ".$page->Item->item_title." Item";
                                throw $this->exception(
                                        $this->notFound(\XF::phrase($phraseKey))
                                );
                }
                
           

        }
        
        
                

        if ($pageOwner->isUpdate()) {

//            $hash = $this->filter('attachment_hash', 'str');
//
//            $sql = "Update xf_attachment set content_id=$pageOwner->page_id where temp_hash='$hash'";
//            $db = \XF::db();
//            $db->query($sql);
            $detail = "";
            $link = "";

            $requests = $this->finder('XenBulletins\BrandHub:PageSub')->where('page_id', $pageOwner->page_id)->with(['User'])->fetch();

            if (strcmp($this->plugin('XF:Editor')->fromInput('about'), $pageOwner->Detail->about)) {

                $detail = $detail . "About";
            }
            if (strcmp($this->plugin('XF:Editor')->fromInput('attachment'), $pageOwner->Detail->attachment)) {

                $detail = $detail . " Attachment";
            }

            if (strcmp($this->plugin('XF:Editor')->fromInput('customizations'), $pageOwner->Detail->customizations)) {

                $detail = $detail . " Customizations";
            }


            if ($detail != '') {


                foreach ($requests as $request) {

                    $link = $this->app->router('public')->buildLink('owners', $request->Page);

                    \XenBulletins\BrandHub\Helper::updatePageNotificiation($pageOwner->Item->item_title, $link, $detail, $request->User);
                }
            }
        }




        $form->basicEntitySave($pageOwner, $input);

        return $form;
    }

    public function actionSave(ParameterBag $params) {
        $this->assertPostOnly();

        if ($params->page_id) {
            $pageOwner = $this->assertOwnerPageExists($params->page_id, 'Detail');
        } else {
            $pageOwner = $this->em()->create('XenBulletins\BrandHub:OwnerPage');
        }
        
        
        

        $this->pageSaveProcess($pageOwner)->run();
        

        $pagedetailEntity = $this->saveDescription($pageOwner);
        
        
        $hash = $this->filter('attachment_hash', 'str');
        $this->associateAttachmentsWithOwnerPage($hash, $pageOwner);

//  $sql = "Update xf_attachment set page_id=$pageOwner->page_id where content_id=$pageOwner->item_id and user_id=$pageOwner->user_id";
//        $db = \XF::db();
//        $db->query($sql);



        $this->pageCount($pageOwner);
       
        $threads = $this->finder('XF:Thread')->where('item_id', $pageOwner->item_id)->where('user_id', \xf::visitor()->user_id)->fetch();
        $pageOwner->discussion_count = count($threads);
        $pageOwner->save();
        

//          return $this->redirect($this->buildLink('owners',$pageOwner));
        
        
//        echo'<pre>';
//        var_dump($pageOwner);exit;
                        
            $viewParams = [
                'userItemPage' => $pageOwner,
                'item' => $pageOwner->Item
           ];

           $reply = $this->view('XenBulletins\BrandHub:Item', 'bh_list_ownerPage', $viewParams);
           $reply->setJsonParam('message', \XF::phrase('your_changes_have_been_saved'));
           return $reply;
    }
    
    
    
    public function associateAttachmentsWithOwnerPage($tempHash, \XenBulletins\BrandHub\Entity\OwnerPage $ownerPage)
    {
            $attachmentFinder = $this->finder('XF:Attachment')
                    ->where('temp_hash', $tempHash);

            /** @var \XF\Entity\Attachment $attachment */
            foreach ($attachmentFinder->fetch() AS $attachment)
            {
                    $attachment->content_type = 'bh_item';
                    $attachment->content_id = $ownerPage->item_id;
                    $attachment->temp_hash = '';
                    $attachment->unassociated = 0;
                    $attachment->user_id = $ownerPage->user_id;
                    $attachment->page_id = $ownerPage->page_id;

                    $attachment->save();
            }
    }

    
    protected function assertOwnerPageExists($id, $with = null, $phraseKey = null) {
        return $this->assertRecordExists('XenBulletins\BrandHub:OwnerPage', $id, $with, $phraseKey);
    }



    protected function assertViewableAttachmentItem($attachmentId) {


        $attachmentitem = $this->em()->find('XF:Attachment', $attachmentId);

        if (!$attachmentitem) {
            throw $this->exception($this->notFound(\XF::phrase('xfmg_requested_media_item_not_found')));
        }


        return $attachmentitem;
    }

  

    public function actionPageSub(ParameterBag $params) {

        $visitor = \XF::visitor();
 
        $pageSub = $this->em()->create('XenBulletins\BrandHub:PageSub');
    
        $pageSub->user_id = $visitor->user_id;
        $pageSub->page_id = $params->page_id;
        $pageSub->save();

        return $this->redirect($this->buildLink('owners/'.$params->page_id.'/'.$params->item_id));
    }
    
    
      public  function getRankRecord($page){
            
            $pageId = $page->page_id;
        
            $sql = "
                SELECT *
                FROM (
                    SELECT
                        op.page_id,
                        RANK() OVER (ORDER BY op.discussion_count DESC) AS discussion_rank,
                        RANK() OVER (ORDER BY op.view_count DESC) AS view_rank,
                        RANK() OVER (ORDER BY op.reaction_score DESC) AS reaction_rank,
                        RANK() OVER (ORDER BY pc.follow_count DESC) AS follow_rank,
                        RANK() OVER (ORDER BY pc.attachment_count DESC) AS attachment_rank
                    FROM bh_owner_page op
                    LEFT JOIN bh_page_count pc ON op.page_id = pc.page_id
                ) AS ranked_pages
                WHERE page_id = ?
            ";

            $pageRank = $this->app->db()->fetchRow($sql, [$pageId]);
          
            return $pageRank;
          
//              $pagePosition=[];
//        
//     
//              
//              
//              $overallPagesDiscussion = $this->finder('XenBulletins\BrandHub:OwnerPage')->order('discussion_count', 'DESC')->fetch();
//              $overallPagesView = $this->finder('XenBulletins\BrandHub:OwnerPage')->order('view_count', 'DESC')->fetch();
//              
//              $overallPagesFollow = $this->finder('XenBulletins\BrandHub:PageCount')->order('follow_count', 'DESC')->fetch();
//              
//              $overallPagesAtachment = $this->finder('XenBulletins\BrandHub:PageCount')->order('attachment_count', 'DESC')->fetch();
//              
//
//              
//              $pagePosition['pageDiscussionPosition']=$this->pageRankPosition($overallPagesDiscussion,$page);
//            
//              $pagePosition['pageViewPosition']=$this->pageRankPosition($overallPagesView, $page);
//
//              $pagePosition['pageFollowPosition']=$this->pageRankPosition($overallPagesFollow, $page);
//              
//              $pagePosition['pageAttachmentPosition']=$this->pageRankPosition($overallPagesAtachment, $page);
//              
//              
//
//              return $pagePosition;

       
    }
    
    
    public function pageRankPosition($records, $checkPosition) {

      
        $position = 0;

        foreach ($records as $record) {



            $position = $position + 1;

            if ($record->page_id == $checkPosition->page_id) {

                break;
            }
        }
        
        

        return $position;
    }
    
    
     public function pageCount($OwnerPage) {


        $PageCount = $this->finder('XenBulletins\BrandHub:PageCount')->where('page_id', $OwnerPage->page_id)->fetchOne();
        
        $follow_count=$this->finder('XenBulletins\BrandHub:PageSub')->where('page_id',$OwnerPage->page_id)->fetch();
        
      
        $attachmentRepo = $this->repository('XF:Attachment');
        $attachmentData = $attachmentRepo->getEditorData('bh_ownerpage', $OwnerPage);
       
        if (!$PageCount) {
            $PageCount = $this->em()->create('XenBulletins\BrandHub:PageCount');
        }

        $PageCount->follow_count = count($follow_count);
        $PageCount->attachment_count = count($attachmentData['attachments']);
        $PageCount->page_id=$OwnerPage->page_id;
        $PageCount->save();
        
        return $PageCount;
    }
    
    
    public  function actionPageThreads(ParameterBag $params){
        
        $page = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('page_id', $params->page_id)->fetchOne();

        $threads = $this->finder('XF:Thread')->where('item_id', $page->item_id)->where('user_id', $page->user_id)->where('discussion_state','visible')->order('thread_id','DESC')->fetch();
        $item = $this->finder('XenBulletins\BrandHub:Item')->where('item_id', $page->item_id)->fetchOne();
        $viewParams = [
            'threads' => $threads,
            'page'=> $page,
            'item' => $item
        
        ];
        
     return $this->view('XenBulletins\BrandHub:Brand', 'ownerPage_thread_lists', $viewParams);
    }
    
    public function actionFilmStripJump(ParameterBag $params) 
    { 
        $ownerPage = $this->assertOwnerpageExists($params->page_id);

        $direction = $this->filter('direction', 'str');
        $jumpFromId = $this->filter('attachment_id', 'uint');

        $jumpFrom = $this->finder('XF:Attachment')->where('attachment_id', $jumpFromId)->fetchOne();
        
        if(!$jumpFrom)
        {
            throw $this->exception($this->notFound(\XF::phrase('bh_requested_item_not_found')));
        }
        

        $filmStripPlugin = $this->plugin('XenBulletins\BrandHub:FilmStrip');

        $filmStripParams = $filmStripPlugin->getFilmStripParamsForJump($jumpFrom, $direction, $ownerPage);

        $viewParams = [
            'ownerPage' => $ownerPage,
            'filmStripParams' => $filmStripParams
        ];

        return $this->view('XenBulletins\BrandHub:Item', 'bh_page_detail', $viewParams);
    }
    
    public function assertLoggedIn()
    {
        if (!$this->isLoggedIn())
        {
                throw $this->exception($this->noPermission());
        }
    }
    
    
    public  function actionmainPhoto(ParameterBag $params){
       

      
      $pageAttachments = $this->finder('XF:Attachment')->where('content_type', 'bh_item')->where('page_id', $params->page_id)->order('attach_date','Desc')->fetch();
        
      if(!count($pageAttachments)){
          
           $phraseKey = "No photo in Onwer page";
                                throw $this->exception(
                                        $this->notFound(\XF::phrase($phraseKey))
                                );
      }
      $selectedAttachment = $this->finder('XF:Attachment')->where('content_type', 'bh_item')->where('page_id', $params->page_id)->where('page_main_photo', 1)->order('attach_date','Desc')->fetchOne();
       

      $page = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('page_id', $params->page_id)->fetchOne();

       
        $viewParams = [
            'pageAttachments' => $pageAttachments,
            'page'=>$page,
            'selectedAttachment'=>$selectedAttachment,
            
        ];
            
        return $this->view('XenBulletins\BrandHub:Item', 'bh_page_main_photo', $viewParams);
       }
       
         public function actionsetMainPhoto(ParameterBag $params){
          
        $page = $this->finder('XenBulletins\BrandHub:OwnerPage')->where('page_id', $params->page_id)->fetchOne();
           
        $mainItem = $this->filter('mainitem', 'int');

        if($mainItem){
            
                    $sql = "Update xf_attachment set page_main_photo=0 where page_id='$params->page_id'";

                    $db = \XF::db();
                    $db->query($sql);

                     $attachment = $this->finder('XF:Attachment')->where('attachment_id', $mainItem)->fetchOne();

                     $attachment->fastUpdate('page_main_photo',1);

                     $attachment->save();
        }
          return $this->redirect($this->buildLink('owners',$page));
           
           
       }
       
       
         public function actionReact(ParameterBag $params)
	{
             if (!\xf::visitor()->hasPermission('bh_brand_hub', 'react_page') || !\xf::visitor()->user_id)
             {
                 return $this->noPermission();
             }
		$page = $this->assertOwnerPageExists($params->page_id);


		$reactionPlugin = $this->plugin('XF:Reaction');
            return	 $reactionPlugin->actionReactSimple($page, 'owners');
                 
	}
        
        public function actionReactions(ParameterBag $params)
	{
	
            
                $page = $this->assertOwnerPageExists($params->page_id);



		$breadcrumbs = $page->getBreadcrumbs();
             
		$title = \XF::phrase('members_who_reacted_to_message_x', ['position' => ($page->position + 1)]);
               

		/* @var \XF\ControllerPlugin\Reaction $reactionPlugin */
		$reactionPlugin = $this->plugin('XF:Reaction');
		return $reactionPlugin->actionReactions(
			$page,
			'owners/reactions',
			$title, $breadcrumbs
		);
	}
    
        
        
        public function actionDelete(ParameterBag $params)
        {
                $page = $this->assertOwnerPageExists($params->page_id);
                
                $plugin = $this->plugin('XenBulletins\BrandHub:Delete');

                return $plugin->actionDelete(
                        $page,
                        $this->buildLink('owners/delete',  $page),
                        $this->buildLink('owners/edit',  $page),
                        $this->buildLink(\XF::options()->bh_main_route.'/item/#ownerPage',$page->Item),
                        $page->User->username.' '.$page->Item->Brand->brand_title.' '.$page->Item->item_title,
                        'bh_ownerPage_delete_confirm',
                        ['item' => $page->Item, 'page' => $page]
                );
        }
        
        
        //***************************** Filters ****************************************************
        
        
        public function actionFilters(ParameterBag $params)
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
                        'route' => 'owners',
		];
		return $this->view('XenBulletins\BrandHub:Filters', 'bh_ownerPage_filters', $viewParams);
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

                       
                        $defaultOrderAndDir = explode(',' , $this->options()->bh_ownerPageDefaultOrder);

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
		// maps [name of sort] => field in/relative to ownerpage entity
		return [
			'page_id' => 'page_id',
                        'view_count' => 'view_count',
                        'discussion_count' => 'discussion_count',
                        'reaction_score' => 'reaction_score'
		];
	}
        
        //---------------------------------------------------------------------------------
        
        
        
        protected function assertViewableItem($itemId)
	{
		$item = $this->em()->find('XenBulletins\BrandHub:Item', $itemId);

		if (!$item)
		{
			throw $this->exception($this->notFound(\XF::phrase('bh_requested_item_not_found')));
		}

		return $item;
	}
        
        
        //******************************* OwnerPage Post *****************************************
        
        /**
	 * @param User $user
	 *
	 * @return \XenBulletins\BrandHub\Service\OwnerPagePost\Creator
	 */
	protected function setupOwnerPagePostCreate(\XenBulletins\BrandHub\Entity\OwnerPage $ownerPage)
	{
		$message = $this->plugin('XF:Editor')->fromInput('message');

		/** @var \XenBulletins\BrandHub\Service\OwnerPagePost\Creator $creator */
		$creator = $this->service('XenBulletins\BrandHub:OwnerPagePost\Creator', $ownerPage);
		$creator->setContent($message);

		$ownerPagePost = $creator->getOwnerPagePost();

		if ($ownerPagePost->OwnerPage->canUploadAndManageAttachmentsOnOwnerPage())
		{
			$creator->setAttachmentHash($this->filter('attachment_hash', 'str'));
		}

		return $creator;
	}

	protected function finalizeOwnerPagePostCreate(\XenBulletins\BrandHub\Service\OwnerPagePost\Creator $creator)
	{
		$creator->sendNotifications();

		$ownerPagePost = $creator->getOwnerPagePost();

		if (\XF::visitor()->user_id)
		{
			if ($ownerPagePost->message_state == 'moderated')
			{
				$this->session()->setHasContentPendingApproval();
			}
		}
	}

	public function actionPost(ParameterBag $params)
	{
		$this->assertPostOnly();
                
                $ownerPage = $this->assertOwnerpageExists($params->page_id);
                
		if (!$ownerPage->canPostOnOwnerPage())
		{
			return $this->noPermission();
		}

		$creator = $this->setupOwnerPagePostCreate($ownerPage);
		$creator->checkForSpam();

		if (!$creator->validate($errors))
		{
			return $this->error($errors);
		}
		$this->assertNotFlooding('post');
		$ownerPagePost = $creator->save();

		$this->finalizeOwnerPagePostCreate($creator);

		if ($this->filter('_xfWithData', 'bool') && $this->request->exists('last_date') && $ownerPagePost->canView())
		{
			$ownerPagePostRepo = $this->getOwnerPagePostRepo();

			$limit = 3;
			$lastDate = $this->filter('last_date', 'uint');
			$style = $this->filter('style', 'str');
			$context = $this->filter('context', 'str');
			$firstUnshownProfilePost = null;

			if ($context == 'all')
			{
				/** @var \XF\Mvc\Entity\Finder $ownerPagePostList */
				$ownerPagePostList = $ownerPagePostRepo->findNewestOwnerPagePosts($lastDate)->with('fullOwnerPage');
				$ownerPagePosts = $ownerPagePostList->fetch($limit)->filterViewable();
			}
			else
			{
				/** @var \XF\Mvc\Entity\Finder $ownerPagePostList */
				$ownerPagePostList = $ownerPagePostRepo->findNewestOwnerPagePostsOnOwnerPage($ownerPage, $lastDate)->with('fullOwnerPage');
				$ownerPagePosts = $ownerPagePostList->fetch($limit + 1)->filterViewable();

				// We fetched one more post than needed, if more than $limit posts were returned,
				// we can show the 'there are more posts' notice
				if ($ownerPagePosts->count() > $limit)
				{
					$firstUnshownProfilePost = $ownerPagePosts->last();

					// Remove the extra post
					$ownerPagePosts = $ownerPagePosts->pop();
				}
			}

			// put the posts into oldest-first order as they will be (essentially prepended) in that order
			$ownerPagePosts = $ownerPagePosts->reverse(true);

			/** @var \XF\Repository\Attachment $attachmentRepo */
			$attachmentRepo = $this->repository('XF:Attachment');

			$ownerPagePostAttachData = [];
			foreach ($ownerPagePosts AS $ownerPagePost)
			{
				if ($ownerPagePost->canUploadAndManageAttachments())
				{
					$ownerPagePostAttachData[$ownerPagePost->post_id] = $attachmentRepo->getEditorData('bh_ownerPage_post_comment', $ownerPagePost);
				}
			}

			$viewParams = [
//				'user' => $user,
                                'ownerPage' => $ownerPage,
				'style' => $style,
				'profilePosts' => $ownerPagePosts,
				'firstUnshownProfilePost' => $firstUnshownProfilePost,
				'profilePostAttachData' => $ownerPagePostAttachData
			];
			$view = $this->view('XF:Member\NewProfilePosts', 'bh_member_post_new_owner_page_posts', $viewParams);
			$view->setJsonParam('lastDate', $ownerPagePosts->last()->post_date);
			return $view;
		}
		else
		{
			return $this->redirect($this->buildLink('owner-page-posts', $ownerPagePost), \XF::phrase('your_owner_page_post_has_been_posted'));
		}
	}
        
        
        
        //*****************************************************************************************
    
    
    
 
}