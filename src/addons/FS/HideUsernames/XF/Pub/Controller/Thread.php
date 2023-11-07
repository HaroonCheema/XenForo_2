<?php

namespace FS\HideUsernames\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
    public function actionIndex(ParameterBag $params)
    {
        $this->assertNotEmbeddedImageRequest();

        $thread = $this->assertViewableThread($params->thread_id, $this->getThreadViewExtraWith());
        $threadTypeHandler = $thread->TypeHandler;

        $overrideReply = $threadTypeHandler->overrideDisplay($thread, $this);
        if ($overrideReply) {
            return $overrideReply;
        }

        $threadRepo = $this->getThreadRepo();

        $filters = $this->getPostListFilterInput($thread);
        $page = $this->filterPage($params->page);
        $perPage = $this->options()->messagesPerPage;

        $this->assertCanonicalUrl($this->buildLink('threads', $thread, ['page' => $page]));

        $effectiveOrder = $this->filter('order', 'str');
        $defaultOrder = $thread->TypeHandler->getDefaultPostListOrder($thread);
        $availableSorts = $this->getAvailablePostListSorts($thread);
        if (!$effectiveOrder || !isset($availableSorts[$effectiveOrder])) {
            $effectiveOrder = $defaultOrder;
        }

        $isSimpleDateDisplay = ($effectiveOrder == 'post_date' && !$filters);

        $postRepo = $this->getPostRepo();

        $postList = $postRepo->findPostsForThreadView($thread);
        $postList->order($availableSorts[$effectiveOrder]);
        $this->applyPostListFilters($thread, $postList, $filters);

        $threadTypeHandler->adjustThreadPostListFinder($thread, $postList, $page, $this->request);

        if ($effectiveOrder == 'post_date' && !$filters) {
            // can only do this if sorting by position
            $postList->onPage($page, $perPage);
        } else {
            $postList->limitByPage($page, $perPage);
        }

        $totalPosts = $filters ? $postList->total() : ($thread->reply_count + 1);
        $this->assertValidPage($page, $perPage, $totalPosts, 'threads', $thread);

        $posts = $postList->fetch();

        if (!$filters && !$posts->count()) {
            if ($page > 1) {
                return $this->redirect($this->buildLink('threads', $thread));
            } else {
                // should never really happen
                return $this->error(\XF::phrase('something_went_wrong_please_try_again'));
            }
        }

        $isFirstPostPinned = $threadTypeHandler->isFirstPostPinned($thread);
        $highlightPostIds = $threadTypeHandler->getHighlightedPostIds($thread, $filters);

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

        $threadPlugin = $this->plugin('XF:Thread');
        $threadPlugin->fetchExtraContentForPostsFullView($posts, $thread);

        $threadViewData = $threadTypeHandler->setupThreadViewData($thread, $posts, $extraFetchIds);

        foreach ($threadViewData->getMainPosts() as $value) {
            $app = \xf::app();
            $serviceHide = $app->service('FS\HideUsernames:HideUserNames');

            $value->message = $serviceHide->replaceUserNames($value->message);
        }

        if ($isFirstPostPinned) {
            $threadViewData->pinFirstPost();
        }
        if ($highlightPostIds) {
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

        if ($isSimpleDateDisplay) {
            $threadRepo->markThreadReadByVisitor($thread, $lastPost->post_date);
        }

        $threadRepo->logThreadView($thread);

        $overrideContext = [
            'page' => $page,
            'effectiveOrder' => $effectiveOrder,
            'filters' => $filters
        ];

        $pageNavFilters = $filters;
        if ($effectiveOrder != $defaultOrder) {
            $pageNavFilters['order'] = $effectiveOrder;
        }

        $creatableThreadTypes = $this->repository('XF:ThreadType')->getThreadTypeListData(
            $thread->Forum->getCreatableThreadTypes(),
            \XF\Repository\ThreadType::FILTER_SINGLE_CONVERTIBLE
        );

        $viewParams = [
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
            'templateOverrides' => $threadTypeHandler->getThreadViewTemplateOverrides($thread, $overrideContext),

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

        list($viewClass, $viewTemplate) = $threadTypeHandler->getThreadViewAndTemplate($thread);
        $viewParams = $threadTypeHandler->adjustThreadViewParams($thread, $viewParams, $this->request);

        return $this->view($viewClass, $viewTemplate, $viewParams);
    }
}
