<?php

namespace AVForums\TagEssentials\XF\Pub\Controller;

/**
 * Class Watched
 *
 * Extends \XF\Pub\Controller\Watched
 *
 * @package AVForums\TagEssentials\XF\Pub\Controller
 */
class Watched extends XFCP_Watched
{
    /**
     * @return \XF\Mvc\Reply\View
     */
    public function actionTags()
    {
        if (!\XF::options()->tagess_navWatchTags)
        {
            return $this->notFound();
        }

        $this->setSectionContext('forums');

        $page = $this->filterPage();
        $perPage = $this->options()->discussionsPerPage;

        \XF::visitor()->cacheNodePermissions();
        $watchedTagFinder = $this->finder('AVForums\TagEssentials:TagWatch')
            ->where('user_id', \XF::visitor()->user_id)
            ->with(['User', 'Tag', 'Tag.SynonymOf']);

        $total = $watchedTagFinder->total();
        $watchedTags = $watchedTagFinder->limitByPage($page, $perPage)->fetch();

        $viewParams = [
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'watchedTags' => $watchedTags
        ];
        return $this->view('AVForums\TagEssentials\XF:Watched\Tags', 'avForumsTagEss_watched_tags_list', $viewParams);
    }

    /**
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     */
    public function actionTagsManage()
    {
        if (!\XF::options()->tagess_navWatchTags)
        {
            return $this->notFound();
        }

        $this->setSectionContext('forums');

        if (!$state = $this->filter('state', 'str'))
        {
            return $this->redirect($this->buildLink('watched/tags'));
        }

        if ($this->isPost())
        {
            /** @var \AVForums\TagEssentials\Repository\TagWatch $tagWatchRepo */
            $tagWatchRepo = $this->repository('AVForums\TagEssentials:TagWatch');

            if ($tagWatchRepo->isValidWatchState($state))
            {
                $tagWatchRepo->setWatchStateForAll(\XF::visitor(), $state);
            }

            return $this->redirect($this->buildLink('watched/tags'));
        }

        $viewParams = [
            'state' => $state
        ];
        return $this->view('AVForums\TagEssentials\XF:Watched\TagsManage', 'avForumsTagEss_watched_tags_manage', $viewParams);
    }

    /**
     * @return \XF\Mvc\Reply\Redirect
     * @throws \XF\Mvc\Reply\Exception
     * @throws \XF\PrintableException
     */
    public function actionTagsUpdate()
    {
        if (!\XF::options()->tagess_navWatchTags)
        {
            return $this->notFound();
        }

        $this->assertPostOnly();
        $this->setSectionContext('forums');

        /** @var \AVForums\TagEssentials\Repository\TagWatch $tagWatchRepo */
        $tagWatchRepo = $this->repository('AVForums\TagEssentials:TagWatch');

        $state = $this->filter('state', 'str');

        if ($state && $tagWatchRepo->isValidWatchState($state))
        {
            $tagIds = $this->filter('tag_ids', 'array-uint');
            $visitor = \XF::visitor();

            $watchedTags = $this->finder('AVForums\TagEssentials:TagWatch')
                ->where('user_id', $visitor->user_id)
                ->where('tag_id', $tagIds)
                ->fetch();

            /** @var \AVForums\TagEssentials\Entity\TagWatch $watchedTag */
            foreach ($watchedTags AS $watchedTag)
            {
                $tagWatchRepo->setWatchState($watchedTag, $state);
            }
        }

        return $this->redirect($this->buildLink('watched/tags'));
    }
}