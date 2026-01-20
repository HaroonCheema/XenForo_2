<?php

namespace FS\PostSortReactions\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Entity\ArrayCollection;
use FS\PostPrefix\Helper;
use XF\ControllerPlugin\ThreadPlugin;
use XF\Repository\UserAlertRepository;
use XF\Repository\ThreadTypeRepository;

class Thread extends XFCP_Thread
{

    public function actionIndex(ParameterBag $params)
    {
        $parent = parent::actionIndex($params);

        $prefixId = $this->filter('prefix_id', 'str');
        $order = $this->filter('order', 'str');

        if ($parent instanceof \XF\Mvc\Reply\View) {
            $forum = $parent->getParam('forum');
            $prefixes = $forum->getUsablePrefixes();
            $prefixes = Helper::excludePrefixes($prefixes);

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
                ', ['thread_id' => $params->thread_id]);

            $drpMenu = [];

            foreach ($drpDownPrefixes as $item) {
                $drpMenu[$item["prefix_group_id"]][] = $item["prefix_id"];
            }

            $videosClipsIds = \XF::options()->pp_videos_and_clips_ids;
            $videosClipsIds = array_map('intval', array_filter(explode(",", $videosClipsIds)));

            //When at least 2 prefix ids provided in options then "Videos and Clips" menu will display
            if (count($videosClipsIds) > 1) {
                //Add Video and Clips prefix at specific index
                foreach ($drpMenu as $outerIndex => $innerArray) {
                    if (($innerIndex = array_search(max($videosClipsIds), $innerArray)) !== false) {
                        $foundIndex = [$outerIndex, $innerIndex];
                        array_splice($drpMenu[$outerIndex], $innerIndex + 1, 0, 'V');
                        break;
                    }
                }
            }

            $parent->setParam('preId', $prefixId);
            $parent->setParam('order', $order);
            $parent->setParam('prefixes', $prefixes);
            $parent->setParam('drpMenu', $drpMenu);                     //Grouped dropDown Menu New
        }

        if ($prefixId || $order) {

            $thread = $this->assertViewableThread($params->thread_id, $this->getThreadViewExtraWith());

            if ($order == 'post_date' and $prefixId)
                return $this->redirect($this->buildLink('threads', $thread, ['prefix_id' => $prefixId]));
            else if ($order == 'post_date' and !$prefixId)
                return $parent;


            $filters = $this->getPostListFilterInput($thread);
            $page = $this->filterPage($params->page);
            $perPage = $this->options()->messagesPerPage;

            $postRepo = $this->getPostRepo();

            $postList = $postRepo->findPostsForThreadView($thread);

            if ($prefixId) {
                $postIds = $this->finder('FS\PostPrefix:PostPrefixes')
                    ->with('Post')
                    ->where('prefix_id', explode(',', $prefixId))
                    ->where('Post.thread_id', $params->thread_id)
                    ->fetch()->pluckNamed('post_id');

                $postList = $postList->where('post_id', $postIds);
            }

            $visitor = \XF::visitor();

            if ($order and $visitor->user_id) {

                if ($order == 'reaction_all') {
                    $postList->order([
                        ['reaction_score', 'DESC'],
                        ['post_date', 'ASC']
                    ]);
                } else {

                    $postList1 = clone $postList;
                    $postIds = $postList1->order([['reaction_score', 'DESC'], ['post_date', 'ASC']])->fetch()->pluckNamed('post_id');

                    $timeCutoff = 0;
                    switch ($order) {
                        case 'reaction_1y':
                            $timeCutoff = \XF::$time - 31536000;
                            break;

                        case 'reaction_1m':
                            $timeCutoff = \XF::$time - 2592000;
                            break;

                        case 'reaction_7d':
                            $timeCutoff = \XF::$time - 604800;
                            break;

                        case 'reaction_today':
                            $timeCutoff = strtotime('today');
                            break;
                    }

                    $postIdsSql = array_map('intval', $postIds);

                    $postIdsSql = implode(',', $postIdsSql);

                    $reactPostIds = \XF::db()->fetchAllColumn("
                        SELECT rc.content_id 
                        FROM `xf_reaction_content` rc
                        JOIN xf_reaction r on rc.reaction_id = r.reaction_id
                        WHERE rc.content_type = 'post'
                        AND rc.content_id in ($postIdsSql)
                        AND rc.reaction_date >= ?
                        GROUP by rc.content_id
                        ORDER BY SUM(r.reaction_score) DESC
                    ", [$timeCutoff]);

                    $reacted = array_intersect($reactPostIds, $postIds);
                    $postIds = array_merge($reacted, array_diff($postIds, $reactPostIds));
                }
            }

            $this->applyPostListFilters($thread, $postList, $filters);

            $thread->TypeHandler->adjustThreadPostListFinder($thread, $postList, $page, $this->request);

            if ($order and $order != 'reaction_all' and $visitor->user_id) {
                $postList->order(
                    $postList->expression('FIELD(xf_post.post_id,' . implode(',', $postIds) . ')')
                );
            }

            $postList->limitByPage($page, $perPage);

            $totalPosts = $filters ? $postList->total() : ($thread->reply_count + 1);

            $this->assertValidPage($page, $perPage, $totalPosts, 'threads', $thread);

            $posts = $postList->fetch();

            if (!$filters && !$posts->count()) {
                return $parent;
            }

            $isFirstPostPinned = $thread->TypeHandler->isFirstPostPinned($thread);
            $highlightPostIds = $thread->TypeHandler->getHighlightedPostIds($thread, $filters);

            $extraFetchIds = [];

            if ($isFirstPostPinned && !isset($posts[$thread->first_post_id])) {
                $extraFetchIds[$thread->first_post_id] = $thread->first_post_id;
            }
            foreach ($highlightPostIds as $highlightPostId) {
                if (!isset($posts[$highlightPostId])) {
                    $extraFetchIds[$highlightPostId] = $highlightPostId;
                }
            }

            if ($extraFetchIds) {
                $extraFinder = $postRepo->findSpecificPostsForThreadView($thread, $extraFetchIds);

                $this->applyPostListFilters($thread, $extraFinder, $filters, $extraFetchIds);
                $thread->TypeHandler->adjustThreadPostListFinder(
                    $thread,
                    $extraFinder,
                    $page,
                    $this->request,
                    $extraFetchIds
                );

                $fetchPinnedPosts = $extraFinder->fetch();
                $posts = $posts->merge($fetchPinnedPosts);
            }

            $threadViewData = $thread->TypeHandler->setupThreadViewData($thread, $posts, $extraFetchIds);

            //Added by Wasif*************
            // $postPrefixes = $this->finder('FS\PostPrefix:PostPrefixes')->with('Post')->where('Post.thread_id', $params->thread_id)->fetch()->pluckNamed('prefix_id');
            // $postPrefixesText = [];

            // foreach ($postPrefixes as $key => $value) {
            //     $postPrefixesText[$prefixTitle = \XF::app()->templater()->fn('prefix_title', ['thread', $value])] = $value;
            // }
            //****************************


            $parent->setParam('posts', $threadViewData->getMainPosts());
            // $parent->setParam('posts', $posts);
        }

        return $parent;
    }



    // public function actionIndex2(ParameterBag $params)
    // {
    //     $parent = parent::actionIndex($params);

    //     $forum = $parent->getParam('forum');
    //     $prefixes = $forum->getUsablePrefixes();
    //     $prefixes = Helper::excludePrefixes($prefixes);

    //     if ($parent instanceof \XF\Mvc\Reply\View) {

    //         // ********* Added by Wasif for Prefix dropdown option ********************
    //         //Grouped dropDown Menu New ****
    //         $db = \XF::db();
    //         $drpDownPrefixes = $db->fetchAll('
    //             SELECT
    //             distinct tp.prefix_group_id,fs.prefix_id 
    //             FROM fs_post_prefixes fs
    //             LEFT JOIN xf_post p on fs.post_id = p.post_id
    //             LEFT JOIN xf_thread t on p.thread_id = t.thread_id
    //             LEFT JOIN xf_thread_prefix tp on fs.prefix_id = tp.prefix_id
    //             where t.thread_id = ?
    //             order by case when tp.prefix_group_id = 0 then 99999 else tp.prefix_group_id end,fs.prefix_id
    //             ', ['thread_id' => $params->thread_id]);

    //         $drpMenu = [];

    //         foreach ($drpDownPrefixes as $item) {
    //             $drpMenu[$item["prefix_group_id"]][] = $item["prefix_id"];
    //         }

    //         $videosClipsIds = \XF::options()->pp_videos_and_clips_ids;
    //         $videosClipsIds = array_map('intval', array_filter(explode(",", $videosClipsIds)));

    //         //When at least 2 prefix ids provided in options then "Videos and Clips" menu will display
    //         // if (count($videosClipsIds) > 1) {
    //         //     //Add Video and Clips prefix at specific index
    //         //     foreach ($drpMenu as $outerIndex => $innerArray) {
    //         //         if (($innerIndex = array_search(max($videosClipsIds), $innerArray)) !== false) {
    //         //             $foundIndex = [$outerIndex, $innerIndex];
    //         //             array_splice($drpMenu[$outerIndex], $innerIndex + 1, 0, 'V');
    //         //             break;
    //         //         }
    //         //     }
    //         // }

    //         $parent->setParam('drpMenu', $drpMenu);                     //Grouped dropDown Menu New
    //     }

    //     if ($this->filter('prefix_id', 'str') || $this->filter('order', 'str')) {
    //         $prefixId = $this->filter('prefix_id', 'str');
    //         $order = $this->filter('order', 'str');

    //         $this->assertNotEmbeddedImageRequest();

    //         $thread = $this->assertViewableThread($params->thread_id, $this->getThreadViewExtraWith());

    //         if ($order == 'post_date' and $prefixId)
    //             return $this->redirect($this->buildLink('threads', $thread, ['prefix_id' => $prefixId]));
    //         else if ($order == 'post_date' and !$prefixId)
    //             return $this->redirect($this->buildLink('threads', $thread));

    //         $overrideReply = $thread->TypeHandler->overrideDisplay($thread, $this);
    //         if ($overrideReply) {
    //             return $overrideReply;
    //         }

    //         $threadRepo = $this->getThreadRepo();
    //         $threadPlugin = $this->plugin(ThreadPlugin::class);

    //         $filters = $this->getPostListFilterInput($thread);
    //         $page = $this->filterPage($params->page);
    //         $perPage = $this->options()->messagesPerPage;

    //         $this->assertCanonicalUrl($this->buildLink('threads', $thread, ['page' => $page]));

    //         $effectiveOrder = $threadPlugin->getEffectivePostListOrder(
    //             $thread,
    //             $this->filter('order', 'str'),
    //             $defaultOrder,
    //             $availableSorts
    //         );

    //         $isSimpleDateDisplay = ($effectiveOrder == 'post_date' && !$filters);

    //         $postRepo = $this->getPostRepo();

    //         $postList = $postRepo->findPostsForThreadView($thread);
    //         // $postList->order($availableSorts[$effectiveOrder]);

    //         if ($prefixId) {
    //             $postIds = $this->finder('FS\PostPrefix:PostPrefixes')
    //                 ->with('Post')
    //                 ->where('prefix_id', explode(',', $prefixId))
    //                 ->where('Post.thread_id', $params->thread_id)
    //                 ->fetch()->pluckNamed('post_id');

    //             $postList = $postList->where('post_id', $postIds);
    //         }

    //         $visitor = \XF::visitor();

    //         if ($order and $visitor->user_id) {

    //             if ($order == 'reaction_all') {
    //                 $postList->order([
    //                     ['reaction_score', 'DESC'],
    //                     ['post_date', 'ASC']
    //                 ]);
    //             } else {

    //                 $postList1 = clone $postList;
    //                 $postIds = $postList1->order([['reaction_score', 'DESC'], ['post_date', 'ASC']])->fetch()->pluckNamed('post_id');

    //                 $timeCutoff = 0;
    //                 switch ($order) {
    //                     case 'reaction_1y':
    //                         $timeCutoff = \XF::$time - 31536000;
    //                         break;

    //                     case 'reaction_1m':
    //                         $timeCutoff = \XF::$time - 2592000;
    //                         break;

    //                     case 'reaction_7d':
    //                         $timeCutoff = \XF::$time - 604800;
    //                         break;

    //                     case 'reaction_today':
    //                         $timeCutoff = strtotime('today');
    //                         break;
    //                 }

    //                 $postIdsSql = array_map('intval', $postIds);

    //                 $postIdsSql = implode(',', $postIdsSql);

    //                 $reactPostIds = \XF::db()->fetchAllColumn("
    //                     SELECT rc.content_id 
    //                     FROM `xf_reaction_content` rc
    //                     JOIN xf_reaction r on rc.reaction_id = r.reaction_id
    //                     WHERE rc.content_type = 'post'
    //                     AND rc.content_id in ($postIdsSql)
    //                     AND rc.reaction_date >= ?
    //                     GROUP by rc.content_id
    //                     ORDER BY SUM(r.reaction_score) DESC
    //                 ", [$timeCutoff]);

    //                 $reacted = array_intersect($reactPostIds, $postIds);
    //                 $postIds = array_merge($reacted, array_diff($postIds, $reactPostIds));
    //             }
    //         }

    //         $this->applyPostListFilters($thread, $postList, $filters);

    //         $thread->TypeHandler->adjustThreadPostListFinder($thread, $postList, $page, $this->request);

    //         // if ($effectiveOrder == 'post_date' && !$filters) {
    //         //     // can only do this if sorting by position
    //         //     $postList->onPage($page, $perPage);
    //         // } else {
    //         //     $postList->limitByPage($page, $perPage);
    //         // }

    //         if ($order and $order != 'reaction_all' and $visitor->user_id) {
    //             $postList->order(
    //                 $postList->expression('FIELD(xf_post.post_id,' . implode(',', $postIds) . ')')
    //             );
    //         }

    //         $postList->limitByPage($page, $perPage);

    //         $totalPosts = $filters ? $postList->total() : ($thread->reply_count + 1);

    //         $this->assertValidPage($page, $perPage, $totalPosts, 'threads', $thread);

    //         /*
    //         // ****** Sorting the posts on reaction count ***********
    //         if($order and $order != 'reaction_all')
    //         {
    //             $postsRaw = $postList->fetch();

    //             $ordered = new ArrayCollection([]);
    //             foreach ($postIds as $id) {
    //                 if (isset($postsRaw[$id])) {
    //                     $ordered[$id] = $postsRaw[$id];
    //                 }
    //             }
    //             $posts = $ordered;
    //         }
    //         else
    //         {
    //             $posts = $postList->fetch();
    //         }
    //         */

    //         $posts = $postList->fetch();

    //         if (!$filters && !$posts->count()) {
    //             if ($page > 1) {
    //                 return $this->redirect($this->buildLink('threads', $thread));
    //             } else {
    //                 // should never really happen
    //                 return $this->error(\XF::phrase('something_went_wrong_please_try_again'));
    //             }
    //         }

    //         $isFirstPostPinned = $thread->TypeHandler->isFirstPostPinned($thread);
    //         $highlightPostIds = $thread->TypeHandler->getHighlightedPostIds($thread, $filters);

    //         $extraFetchIds = [];

    //         if ($isFirstPostPinned && !isset($posts[$thread->first_post_id])) {
    //             $extraFetchIds[$thread->first_post_id] = $thread->first_post_id;
    //         }
    //         foreach ($highlightPostIds as $highlightPostId) {
    //             if (!isset($posts[$highlightPostId])) {
    //                 $extraFetchIds[$highlightPostId] = $highlightPostId;
    //             }
    //         }

    //         if ($extraFetchIds) {
    //             $extraFinder = $postRepo->findSpecificPostsForThreadView($thread, $extraFetchIds);

    //             $this->applyPostListFilters($thread, $extraFinder, $filters, $extraFetchIds);
    //             $thread->TypeHandler->adjustThreadPostListFinder(
    //                 $thread,
    //                 $extraFinder,
    //                 $page,
    //                 $this->request,
    //                 $extraFetchIds
    //             );

    //             $fetchPinnedPosts = $extraFinder->fetch();
    //             $posts = $posts->merge($fetchPinnedPosts);
    //         }

    //         $threadPlugin->fetchExtraContentForPostsFullView($posts, $thread);

    //         $threadViewData = $thread->TypeHandler->setupThreadViewData($thread, $posts, $extraFetchIds);
    //         if ($isFirstPostPinned) {
    //             $threadViewData->pinFirstPost();
    //         }
    //         if ($highlightPostIds) {
    //             $threadViewData->addHighlightedPosts($highlightPostIds);
    //         }

    //         /** @var UserAlertRepository $userAlertRepo */
    //         $userAlertRepo = $this->repository(UserAlertRepository::class);
    //         $userAlertRepo->markUserAlertsReadForContent(
    //             'post',
    //             array_keys($threadViewData->getFullyDisplayedPosts())
    //         );

    //         // note that this is the last shown post -- might not be date ordered any longer
    //         $lastPost = $threadViewData->getLastPost();

    //         // $prefixes = $thread->Forum->getUsablePrefixes();

    //         // $prefixes = Helper::excludePrefixes($prefixes);

    //         if ($isSimpleDateDisplay && !$this->request->isPrefetch()) {
    //             $threadRepo->markThreadReadByVisitor($thread, $lastPost->post_date);
    //         }

    //         if ($this->isContentViewCounted()) {
    //             $threadRepo->logThreadView($thread);
    //         }

    //         $overrideContext = [
    //             'page' => $page,
    //             'effectiveOrder' => $effectiveOrder,
    //             'filters' => $filters,
    //         ];

    //         $pageNavFilters = $filters;
    //         if ($effectiveOrder != $defaultOrder) {
    //             $pageNavFilters['order'] = $effectiveOrder;
    //         }

    //         $creatableThreadTypes = $this->repository(ThreadTypeRepository::class)->getThreadTypeListData(
    //             $thread->Forum->getCreatableThreadTypes(),
    //             ThreadTypeRepository::FILTER_SINGLE_CONVERTIBLE
    //         );

    //         //Added by Wasif*************
    //         // $postPrefixes = $this->finder('FS\PostPrefix:PostPrefixes')->with('Post')->where('Post.thread_id', $params->thread_id)->fetch()->pluckNamed('prefix_id');
    //         // $postPrefixesText = [];

    //         // foreach ($postPrefixes as $key => $value) {
    //         //     $postPrefixesText[$prefixTitle = \XF::app()->templater()->fn('prefix_title', ['thread', $value])] = $value;
    //         // }
    //         //****************************

    //         $viewParams = [
    //             'preId' => $prefixId,                       //Added by Wasif
    //             'order' => $order,
    //             //'postPrefixesText' => $postPrefixesText,    //Ungrouped dropDown Menu Old
    //             'drpMenu' => $drpMenu ?? [],                      //Grouped dropDown Menu New
    //             'prefixes' => $prefixes,

    //             'thread' => $thread,
    //             'forum' => $thread->Forum,
    //             'posts' => $threadViewData->getMainPosts(),
    //             'firstPost' => $threadViewData->getFirstPost(),
    //             'lastPost' => $lastPost,
    //             'firstUnread' => $threadViewData->getFirstUnread(),
    //             'isSimpleDateDisplay' => $isSimpleDateDisplay,
    //             'creatableThreadTypes' => $creatableThreadTypes,

    //             'isFirstPostPinned' => $isFirstPostPinned,
    //             'pinnedPost' => $threadViewData->getPinnedFirstPost(),
    //             'highlightedPosts' => $threadViewData->getHighlightedPosts(),
    //             'templateOverrides' => $thread->TypeHandler->getThreadViewTemplateOverrides($thread, $overrideContext),

    //             'availableSorts' => $availableSorts,
    //             'defaultOrder' => $defaultOrder,
    //             'effectiveOrder' => $effectiveOrder,
    //             'filters' => $filters,

    //             'canInlineMod' => $threadViewData->canUseInlineModeration(),

    //             'page' => $page,
    //             'perPage' => $perPage,
    //             'totalPosts' => $totalPosts,
    //             'pageNavFilters' => $pageNavFilters,
    //             'pageNavHash' => $isFirstPostPinned ? '>1:#posts' : '',

    //             'attachmentData' => $this->getReplyAttachmentData($thread),

    //             'pendingApproval' => $this->filter('pending_approval', 'bool'),
    //         ];

    //         [$viewClass, $viewTemplate] = $thread->TypeHandler->getThreadViewAndTemplate($thread);
    //         $viewParams = $thread->TypeHandler->adjustThreadViewParams($thread, $viewParams, $this->request);

    //         return $this->view($viewClass, $viewTemplate, $viewParams);
    //     } else {
    //         return $parent;
    //         // return parent::actionIndex($params);
    //     }
    // }




    // public function actionIndex1(ParameterBag $params)
    // {
    //     $parent = parent::actionIndex($params);

    //     if ($parent instanceof \XF\Mvc\Reply\View) {
    //         $forum = $parent->getParam('forum');
    //         $prefixes = $forum->getUsablePrefixes();
    //         $prefixes = Helper::excludePrefixes($prefixes);
    //         $parent->setParam('prefixes', $prefixes);

    //         // ********* Added by Wasif for Prefix dropdown option ********************
    //         //Grouped dropDown Menu New ****
    //         $db = \XF::db();
    //         $drpDownPrefixes = $db->fetchAll('
    //             SELECT
    //             distinct tp.prefix_group_id,fs.prefix_id 
    //             FROM fs_post_prefixes fs
    //             LEFT JOIN xf_post p on fs.post_id = p.post_id
    //             LEFT JOIN xf_thread t on p.thread_id = t.thread_id
    //             LEFT JOIN xf_thread_prefix tp on fs.prefix_id = tp.prefix_id
    //             where t.thread_id = ?
    //             order by case when tp.prefix_group_id = 0 then 99999 else tp.prefix_group_id end,fs.prefix_id
    //             ', ['thread_id' => $params->thread_id]);

    //         $drpMenu = [];

    //         foreach ($drpDownPrefixes as $item) {
    //             $drpMenu[$item["prefix_group_id"]][] = $item["prefix_id"];
    //         }

    //         $videosClipsIds = \XF::options()->pp_videos_and_clips_ids;
    //         $videosClipsIds = array_map('intval', array_filter(explode(",", $videosClipsIds)));

    //         //When at least 2 prefix ids provided in options then "Videos and Clips" menu will display
    //         if (count($videosClipsIds) > 1) {
    //             //Add Video and Clips prefix at specific index
    //             foreach ($drpMenu as $outerIndex => $innerArray) {
    //                 if (($innerIndex = array_search(max($videosClipsIds), $innerArray)) !== false) {
    //                     $foundIndex = [$outerIndex, $innerIndex];
    //                     array_splice($drpMenu[$outerIndex], $innerIndex + 1, 0, 'V');
    //                     break;
    //                 }
    //             }
    //         }


    //         $prefixId = $this->filter('prefix_id', 'str');
    //         $order = $this->filter('order', 'str');

    //         $parent->setParam('preId', $prefixId);
    //         $parent->setParam('order', $order);
    //         $parent->setParam('drpMenu', $drpMenu);                     //Grouped dropDown Menu New
    //     }


    //     if ($this->filter('prefix_id', 'str') || $this->filter('order', 'str')) {
    //         $prefixId = $this->filter('prefix_id', 'str');
    //         $order = $this->filter('order', 'str');

    //         $this->assertNotEmbeddedImageRequest();
    //         $thread = $this->assertViewableThread($params->thread_id, $this->getThreadViewExtraWith());

    //         if ($order == 'post_date' and $prefixId)
    //             return $this->redirect($this->buildLink('threads', $thread, ['prefix_id' => $prefixId]));
    //         else if ($order == 'post_date' and !$prefixId)
    //             return $this->redirect($this->buildLink('threads', $thread));

    //         $threadRepo = $this->getThreadRepo();
    //         $threadPlugin = $this->plugin('XF:Thread');

    //         $filters = $this->getPostListFilterInput($thread);

    //         $page = $this->filterPage($params->page);

    //         $perPage = $this->options()->messagesPerPage;

    //         $effectiveOrder = $threadPlugin->getEffectivePostListOrder(
    //             $thread,
    //             $this->filter('order', 'str'),
    //             $defaultOrder,
    //             $availableSorts
    //         );

    //         $isSimpleDateDisplay = ($effectiveOrder == 'post_date' && !$filters);

    //         $postRepo = $this->getPostRepo();
    //         $postList = $postRepo->findPostsForThreadView($thread);

    //         // var_dump($postList->getQuery());exit;


    //         //If prefix selected from menu
    //         if ($prefixId) {
    //             $postIds = $this->finder('FS\PostPrefix:PostPrefixes')
    //                 ->with('Post')
    //                 ->where('prefix_id', explode(',', $prefixId))
    //                 ->where('Post.thread_id', $params->thread_id)
    //                 ->fetch()->pluckNamed('post_id');

    //             $postList = $postList->where('post_id', $postIds);
    //         }


    //         $visitor = \XF::visitor();

    //         if ($order and $visitor->user_id) {

    //             if ($order == 'reaction_all') {
    //                 $postList->order([
    //                     ['reaction_score', 'DESC'],
    //                     ['post_date', 'ASC']
    //                 ]);
    //             } else {

    //                 $postList1 = clone $postList;
    //                 $postIds = $postList1->order([['reaction_score', 'DESC'], ['post_date', 'ASC']])->fetch()->pluckNamed('post_id');

    //                 // var_dump($postList->getQuery());exit;

    //                 $timeCutoff = 0;
    //                 switch ($order) {
    //                     case 'reaction_1y':
    //                         $timeCutoff = \XF::$time - 31536000;
    //                         break;

    //                     case 'reaction_1m':
    //                         $timeCutoff = \XF::$time - 2592000;
    //                         break;

    //                     case 'reaction_7d':
    //                         $timeCutoff = \XF::$time - 604800;
    //                         break;

    //                     case 'reaction_today':
    //                         $timeCutoff = strtotime('today');
    //                         break;
    //                 }

    //                 $postIdsSql = array_map('intval', $postIds);
    //                 $postIdsSql = implode(',', $postIdsSql);

    //                 $reactPostIds = \XF::db()->fetchAllColumn("
    //                     SELECT rc.content_id 
    //                     FROM `xf_reaction_content` rc
    //                     JOIN xf_reaction r on rc.reaction_id = r.reaction_id
    //                     WHERE rc.content_type = 'post'
    //                     AND rc.content_id in ($postIdsSql)
    //                     AND rc.reaction_date >= ?
    //                     GROUP by rc.content_id
    //                     ORDER BY SUM(r.reaction_score) DESC
    //                 ", [$timeCutoff]);

    //                 $reacted = array_intersect($reactPostIds, $postIds);
    //                 $postIds = array_merge($reacted, array_diff($postIds, $reactPostIds));
    //             }
    //         }


    //         $this->applyPostListFilters($thread, $postList, $filters);

    //         $thread->TypeHandler->adjustThreadPostListFinder($thread, $postList, $page, $this->request);


    //         if ($order and $order != 'reaction_all' and $visitor->user_id) {
    //             $postList->order(
    //                 $postList->expression('FIELD(xf_post.post_id,' . implode(',', $postIds) . ')')
    //             );
    //         }


    //         $postList->limitByPage($page, $perPage);

    //         $totalPosts = $filters ? $postList->total() : ($thread->reply_count + 1);
    //         $totalPosts = $postList->total();

    //         $this->assertValidPage($page, $perPage, $totalPosts, 'threads', $thread);
    //         //var_dump($postList->getQuery());exit;

    //         /*
    //         // ****** Sorting the posts on reaction count ***********
    //         if($order and $order != 'reaction_all')
    //         {
    //             $postsRaw = $postList->fetch();

    //             $ordered = new ArrayCollection([]);
    //             foreach ($postIds as $id) {
    //                 if (isset($postsRaw[$id])) {
    //                     $ordered[$id] = $postsRaw[$id];
    //                 }
    //             }
    //             $posts = $ordered;
    //         }
    //         else
    //         {
    //             $posts = $postList->fetch();
    //         }
    //         */

    //         $posts = $postList->fetch();

    //         //*******************************************************
    //         if (!$filters && !$posts->count()) {
    //             if ($page > 1) {
    //                 return $this->redirect($this->buildLink('threads', $thread));
    //             } else {
    //                 // should never really happen
    //                 return $this->error(\XF::phrase('something_went_wrong_please_try_again'));
    //             }
    //         }


    //         $isFirstPostPinned = $thread->TypeHandler->isFirstPostPinned($thread);
    //         $highlightPostIds = $thread->TypeHandler->getHighlightedPostIds($thread, $filters);

    //         $extraFetchIds = [];

    //         if ($isFirstPostPinned && !isset($posts[$thread->first_post_id])) {
    //             $extraFetchIds[$thread->first_post_id] = $thread->first_post_id;
    //         }
    //         foreach ($highlightPostIds as $highlightPostId) {
    //             if (!isset($posts[$highlightPostId])) {
    //                 $extraFetchIds[$highlightPostId] = $highlightPostId;
    //             }
    //         }

    //         if ($extraFetchIds) {
    //             $extraFinder = $postRepo->findSpecificPostsForThreadView($thread, $extraFetchIds);

    //             $this->applyPostListFilters($thread, $extraFinder, $filters, $extraFetchIds);
    //             $thread->TypeHandler->adjustThreadPostListFinder(
    //                 $thread,
    //                 $extraFinder,
    //                 $page,
    //                 $this->request,
    //                 $extraFetchIds
    //             );

    //             $fetchPinnedPosts = $extraFinder->fetch();
    //             $posts = $posts->merge($fetchPinnedPosts);
    //         }

    //         $threadPlugin->fetchExtraContentForPostsFullView($posts, $thread);

    //         $threadViewData = $thread->TypeHandler->setupThreadViewData($thread, $posts, $extraFetchIds);
    //         if ($isFirstPostPinned) {
    //             $threadViewData->pinFirstPost();
    //         }
    //         if ($highlightPostIds) {
    //             $threadViewData->addHighlightedPosts($highlightPostIds);
    //         }

    //         /** @var \XF\Repository\UserAlert $userAlertRepo */
    //         $userAlertRepo = $this->repository('XF:UserAlert');
    //         $userAlertRepo->markUserAlertsReadForContent(
    //             'post',
    //             array_keys($threadViewData->getFullyDisplayedPosts())
    //         );

    //         // note that this is the last shown post -- might not be date ordered any longer
    //         $lastPost = $threadViewData->getLastPost();

    //         $isPrefetchRequest = $this->request->isPrefetch();

    //         if ($isSimpleDateDisplay && !$isPrefetchRequest) {
    //             $threadRepo->markThreadReadByVisitor($thread, $lastPost->post_date);
    //         }

    //         if (!$isPrefetchRequest) {
    //             $threadRepo->logThreadView($thread);
    //         }

    //         $prefixes = $thread->Forum->getUsablePrefixes();

    //         $prefixes = Helper::excludePrefixes($prefixes);

    //         $overrideContext = [
    //             'page' => $page,
    //             'effectiveOrder' => $effectiveOrder,
    //             'filters' => $filters
    //         ];

    //         $pageNavFilters = $filters;

    //         // if ($effectiveOrder != $defaultOrder)
    //         //     $pageNavFilters['order'] = $effectiveOrder;


    //         $pageNavFilters['order'] = $order;

    //         $creatableThreadTypes = $this->repository('XF:ThreadType')->getThreadTypeListData(
    //             $thread->Forum->getCreatableThreadTypes(),
    //             \XF\Repository\ThreadType::FILTER_SINGLE_CONVERTIBLE
    //         );


    //         //Added by Wasif*************
    //         $postPrefixes = $this->finder('FS\PostPrefix:PostPrefixes')->with('Post')->where('Post.thread_id', $params->thread_id)->fetch()->pluckNamed('prefix_id');
    //         $postPrefixesText = [];

    //         foreach ($postPrefixes as $key => $value) {
    //             $postPrefixesText[$prefixTitle = \XF::app()->templater()->fn('prefix_title', ['thread', $value])] = $value;
    //         }
    //         //****************************

    //         $viewParams = [
    //             'preId' => $prefixId,                       //Added by Wasif
    //             'order' => $order,
    //             //'postPrefixesText' => $postPrefixesText,    //Ungrouped dropDown Menu Old
    //             'drpMenu' => $drpMenu,                      //Grouped dropDown Menu New
    //             'thread' => $thread,
    //             'forum' => $thread->Forum,
    //             'posts' => $threadViewData->getMainPosts(),
    //             'firstPost' => $threadViewData->getFirstPost(),
    //             'lastPost' => $lastPost,
    //             'firstUnread' => $threadViewData->getFirstUnread(),
    //             'isSimpleDateDisplay' => $isSimpleDateDisplay,
    //             'creatableThreadTypes' => $creatableThreadTypes,

    //             'isFirstPostPinned' => $isFirstPostPinned,
    //             'pinnedPost' => $threadViewData->getPinnedFirstPost(),
    //             'highlightedPosts' => $threadViewData->getHighlightedPosts(),
    //             'templateOverrides' => $thread->TypeHandler->getThreadViewTemplateOverrides($thread, $overrideContext),
    //             'prefixes' => $prefixes,
    //             'availableSorts' => $availableSorts,
    //             'defaultOrder' => $defaultOrder,
    //             'effectiveOrder' => $effectiveOrder,
    //             'filters' => $filters,

    //             'canInlineMod' => $threadViewData->canUseInlineModeration(),

    //             'page' => $page,
    //             'perPage' => $perPage,
    //             'totalPosts' => $totalPosts,
    //             'pageNavFilters' => $pageNavFilters,
    //             'pageNavHash' => $isFirstPostPinned ? '>1:#posts' : '',

    //             'attachmentData' => $this->getReplyAttachmentData($thread),

    //             'pendingApproval' => $this->filter('pending_approval', 'bool')
    //         ];

    //         list($viewClass, $viewTemplate) = $thread->TypeHandler->getThreadViewAndTemplate($thread);
    //         $viewParams = $thread->TypeHandler->adjustThreadViewParams($thread, $viewParams, $this->request);
    //         return $this->view($viewClass, $viewTemplate, $viewParams);
    //     } else {
    //         return $parent;
    //     }
    // }
}
