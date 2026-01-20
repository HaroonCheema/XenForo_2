<?php

namespace FS\PostPrefix\XF\Pub\Controller;
use XF\Mvc\ParameterBag;
use FS\PostPrefix\Helper;

class Thread extends XFCP_Thread
{
    public function actionIndex(ParameterBag $params)
    {
        $parent = parent::actionIndex($params);

        if($parent instanceof \XF\Mvc\Reply\View)
        {
            $forum = $parent->getParam('forum');
            $prefixes = $forum->getUsablePrefixes();
            $prefixes = Helper::excludePrefixes($prefixes);
            $parent->setParam('prefixes', $prefixes);            

            // ********* Added by Wasif for Prefix dropdown option ********************
            //Grouped dropDown Menu New ****
            $db = \XF::db();
            $drpDownPrefixes = $db->fetchAll('
                SELECT
                distinct tp.prefix_group_id,fs.prefix_id 
                FROM fs_post_prefixes fs
                LEFT JOIN xf_post p on fs.post_id = p.post_id
                LEFT JOIN xf_thread t on p.thread_id = t.thread_id
                LEFT JOIN xf_thread_prefix tp on fs.prefix_id = tp.prefix_id
                where t.thread_id = ?
                order by case when tp.prefix_group_id = 0 then 99999 else tp.prefix_group_id end,fs.prefix_id
                ',['thread_id' => $params->thread_id]);

            $drpMenu = [];

            foreach ($drpDownPrefixes as $item) {
                $drpMenu[$item["prefix_group_id"]][] = $item["prefix_id"];
            }

            $videosClipsIds = \XF::options()->pp_videos_and_clips_ids;
            $videosClipsIds = array_map('intval', array_filter(explode(",", $videosClipsIds)));

            //When at least 2 prefix ids provided in options then "Videos and Clips" menu will display
            if(count($videosClipsIds) > 1)  
            {
                //Add Video and Clips prefix at specific index
                foreach ($drpMenu as $outerIndex => $innerArray)
                {
                    if (($innerIndex = array_search(max($videosClipsIds), $innerArray)) !== false) 
                    {
                        $foundIndex = [$outerIndex, $innerIndex];
                        array_splice($drpMenu[$outerIndex], $innerIndex + 1, 0, 'V');
                        break;
                    }
                }
            }

            /*
            //Ungrouped dropDown Menu Old *************************
            $postPrefixes = $this->finder('FS\PostPrefix:PostPrefixes')->with('Post')->where('Post.thread_id', $params->thread_id)->fetch()->pluckNamed('prefix_id');
            $postPrefixesText = [];
            foreach ($postPrefixes as $key => $value) 
            {
                $postPrefixesText[
                    $prefixTitle = \XF::app()->templater()->fn('prefix_title', ['thread', $value] )
                ] = $value;
            }
            $parent->setParam('postPrefixesText', $postPrefixesText);   //Ungrouped dropDown Menu Old
            */

            $prefixId = $this->filter('prefix_id','uint');
            $parent->setParam('preId', $prefixId);
            $parent->setParam('drpMenu', $drpMenu);                     //Grouped dropDown Menu New
        }

        if ($this->filter('prefix_id','str'))
        {
            $this->assertNotEmbeddedImageRequest();
            $thread = $this->assertViewableThread($params->thread_id, $this->getThreadViewExtraWith());

            // $overrideReply = $thread->TypeHandler->overrideDisplay($thread, $this);
            // if ($overrideReply)
            // {
            //     return $overrideReply;
            // }


            $prefixId = $this->filter('prefix_id','str');
            $postIds = $this->finder('FS\PostPrefix:PostPrefixes')->with('Post')->where('prefix_id',explode(",", $prefixId))->where('Post.thread_id', $params->thread_id)->fetch()->pluckNamed('post_id');

            $threadRepo = $this->getThreadRepo();
            $threadPlugin = $this->plugin('XF:Thread');

            $filters = $this->getPostListFilterInput($thread);
            
            $page = $this->filterPage($params->page);
            //$page = $this->filterPage();

            $perPage = $this->options()->messagesPerPage;

            // $this->assertCanonicalUrl($this->buildLink('threads', $thread, ['page' => $page]));

            $effectiveOrder = $threadPlugin->getEffectivePostListOrder(
                $thread,
                $this->filter('order', 'str'),
                $defaultOrder,
                $availableSorts
            );

            $isSimpleDateDisplay = ($effectiveOrder == 'post_date' && !$filters);

            $postRepo = $this->getPostRepo();

            $postList = $postRepo->findPostsForThreadView($thread);
            $postList=$postList->where('post_id', $postIds);
            
            $postList->order($availableSorts[$effectiveOrder]);
            $this->applyPostListFilters($thread, $postList, $filters);

            $thread->TypeHandler->adjustThreadPostListFinder($thread, $postList, $page, $this->request);

            if ($effectiveOrder == 'post_date' && !$filters)
            {
                // can only do this if sorting by position
                //$postList->onPage($page, $perPage);
                $postList->limitByPage($page, $perPage);
            }
            else
            {   
                $postList->limitByPage($page, $perPage);
            }

            $totalPosts = $filters ? $postList->total() : ($thread->reply_count + 1);
            $totalPosts= $postList->total();

            $this->assertValidPage($page, $perPage, $totalPosts, 'threads', $thread);
            //var_dump($postList->getQuery());exit;
            $posts = $postList->fetch();

            if (!$filters && !$posts->count())
            {
                if ($page > 1)
                {
                    return $this->redirect($this->buildLink('threads', $thread));
                }
                else
                {
                    // should never really happen
                    return $this->error(\XF::phrase('something_went_wrong_please_try_again'));
                }
            }

            $isFirstPostPinned = $thread->TypeHandler->isFirstPostPinned($thread);
            $highlightPostIds = $thread->TypeHandler->getHighlightedPostIds($thread, $filters);

            $extraFetchIds = [];

            if ($isFirstPostPinned && !isset($posts[$thread->first_post_id]))
            {
                $extraFetchIds[$thread->first_post_id] = $thread->first_post_id;
            }
            foreach ($highlightPostIds AS $highlightPostId)
            {
                if (!isset($posts[$highlightPostId]))
                {
                    $extraFetchIds[$highlightPostId] = $highlightPostId;
                }
            }

            if ($extraFetchIds)
            {
                $extraFinder = $postRepo->findSpecificPostsForThreadView($thread, $extraFetchIds);

                $this->applyPostListFilters($thread, $extraFinder, $filters, $extraFetchIds);
                $thread->TypeHandler->adjustThreadPostListFinder(
                    $thread, $extraFinder, $page, $this->request, $extraFetchIds
                );

                $fetchPinnedPosts = $extraFinder->fetch();
                $posts = $posts->merge($fetchPinnedPosts);
            }

            $threadPlugin->fetchExtraContentForPostsFullView($posts, $thread);

            $threadViewData = $thread->TypeHandler->setupThreadViewData($thread, $posts, $extraFetchIds);
            if ($isFirstPostPinned)
            {
                $threadViewData->pinFirstPost();
            }
            if ($highlightPostIds)
            {
                $threadViewData->addHighlightedPosts($highlightPostIds);
            }

            /** @var \XF\Repository\UserAlert $userAlertRepo */
            $userAlertRepo = $this->repository('XF:UserAlert');
            $userAlertRepo->markUserAlertsReadForContent(
                'post',
                array_keys($threadViewData->getFullyDisplayedPosts())
            );

            // note that this is the last shown post -- might not be date ordered any longer
            $lastPost = $threadViewData->getLastPost();

            $isPrefetchRequest = $this->request->isPrefetch();

            if ($isSimpleDateDisplay && !$isPrefetchRequest)
            {
                $threadRepo->markThreadReadByVisitor($thread, $lastPost->post_date);
            }

            if (!$isPrefetchRequest)
            {
                $threadRepo->logThreadView($thread);
            }

            $prefixes = $thread->Forum->getUsablePrefixes();

            $prefixes = Helper::excludePrefixes($prefixes);
           
            $overrideContext = [
                'page' => $page,
                'effectiveOrder' => $effectiveOrder,
                'filters' => $filters
            ];

            $pageNavFilters = $filters;
            if ($effectiveOrder != $defaultOrder)
            {
                $pageNavFilters['order'] = $effectiveOrder;
            }

            $creatableThreadTypes = $this->repository('XF:ThreadType')->getThreadTypeListData(
                $thread->Forum->getCreatableThreadTypes(),
                \XF\Repository\ThreadType::FILTER_SINGLE_CONVERTIBLE
            );


            //Added by Wasif*************
            $postPrefixes = $this->finder('FS\PostPrefix:PostPrefixes')->with('Post')->where('Post.thread_id', $params->thread_id)->fetch()->pluckNamed('prefix_id');
            $postPrefixesText = [];

            foreach ($postPrefixes as $key => $value) 
            {
                $postPrefixesText[
                    $prefixTitle = \XF::app()->templater()->fn('prefix_title', ['thread', $value] )
                ] = $value;
            }
            //****************************

            $viewParams = [
                'preId' => $prefixId,                       //Added by Wasif
                //'postPrefixesText' => $postPrefixesText,    //Ungrouped dropDown Menu Old
                'drpMenu' => $drpMenu,                      //Grouped dropDown Menu New
                'thread' => $thread,
                'forum' => $thread->Forum,
                'posts' => $threadViewData->getMainPosts(),
                'firstPost' => $threadViewData->getFirstPost(),
                'lastPost' => $lastPost,
                'firstUnread' => $threadViewData->getFirstUnread(),
                'isSimpleDateDisplay' => $isSimpleDateDisplay,
                'creatableThreadTypes' => $creatableThreadTypes,

                'isFirstPostPinned' => $isFirstPostPinned,
                'pinnedPost' => $threadViewData->getPinnedFirstPost(),
                'highlightedPosts' => $threadViewData->getHighlightedPosts(),
                'templateOverrides' => $thread->TypeHandler->getThreadViewTemplateOverrides($thread, $overrideContext),
                'prefixes'=>$prefixes,
                'availableSorts' => $availableSorts,
                'defaultOrder' => $defaultOrder,
                'effectiveOrder' => $effectiveOrder,
                'filters' => $filters,

                'canInlineMod' => $threadViewData->canUseInlineModeration(),

                'page' => $page,
                'perPage' => $perPage,
                'totalPosts' => $totalPosts,
                'pageNavFilters' => $pageNavFilters,
                'pageNavHash' => $isFirstPostPinned ? '>1:#posts' : '',

                'attachmentData' => $this->getReplyAttachmentData($thread),

                'pendingApproval' => $this->filter('pending_approval', 'bool')
            ];

            list($viewClass, $viewTemplate) = $thread->TypeHandler->getThreadViewAndTemplate($thread);
            $viewParams = $thread->TypeHandler->adjustThreadViewParams($thread, $viewParams, $this->request);
            return $this->view($viewClass, $viewTemplate, $viewParams);
        }
        else
        {
          return $parent;
        }

    }
        
    protected function setupThreadReply(\XF\Entity\Thread $thread)
    {
        if(Helper::isApplicableForum($thread->Forum))
        { 
            $postPrefixIds = $this->filter('sv_prefix_ids', 'array-uint');

            if(!$postPrefixIds)
            {
                throw new \XF\PrintableException(\XF::phrase('please_select_at_least_one_prefix'));
            }
        }
        
        return parent::setupThreadReply($thread);
    }

    protected function finalizeThreadReply(\XF\Service\Thread\Replier $replier)
    {
        $postPrefixIds = $this->filter('sv_prefix_ids', 'array-uint');        

        if($postPrefixIds)
        {
            $post = $replier->getPost();
            $post->sv_prefix_ids = $postPrefixIds;
            $post->save();

            Helper::insertPostPrefixes($post->post_id, $postPrefixIds);
        }

        return parent::finalizeThreadReply($replier);
    }
    
    public function PrefixPosts($params)
    {
        /*
        $thread = $this->assertViewableThread($params->thread_id);
        $prefixId = $this->filter('prefix_id','uint');
        $prefixPosts = $this->finder('FS\PostPrefix:PostPrefixes')->with('Post')->where('prefix_id',$prefixId)->where('Post.thread_id', $params->thread_id)->fetch();

        $viewParams = [

            'thread' => $thread,
            'prefixPosts' => $prefixPosts,
        ];

        return $this->view('FS\PostPrefix:Thread', 'pp_thread_list', $viewParams);
        */
    }
}