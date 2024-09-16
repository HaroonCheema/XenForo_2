<?php

namespace AVForums\TagEssentials\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;
use XF\Mvc\Reply\Error;

/**
 * Class Tag
 *
 * @package AVForums\TagEssentials\XF\Pub\Controller
 */
class Tag extends XFCP_Tag
{
    /**
     * @param ParameterBag $params
     *
     * @return View
     */
    public function actionIndex(ParameterBag $params)
    {
        \XF::visitor()->cacheNodePermissions();

        $response = parent::actionIndex($params);

        if ($response instanceof View)
        {
            $options = $this->options();
            $cloudOption = $options->tagCloud;
            if ($cloudOption['enabled'] && $options->tagess_categoriesEnabled)
            {
                /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
                $tagRepo = $this->getTagRepo();
                $cloudEntries = $tagRepo->getTagsForGroupedCloud($cloudOption['count'], $options->tagCloudMinUses);
                $tagCloudGrouped = $tagRepo->getTagGroupedCloud($cloudEntries);
            }
            else
            {
                $tagCloudGrouped = [];
            }

            $response->setParam('tagCloudGrouped', $tagCloudGrouped);
        }

        return $response;
    }

    /**
     * @param \XF\Entity\Tag|\AVForums\TagEssentials\XF\Entity\Tag $tag
     * @param null $error
     *
     * @return bool
     */
    protected function assertTagEditable(\XF\Entity\Tag $tag, &$error = null)
    {
        return $tag->canEditCategory($error) || $tag->canEditWiki($error);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return Error|View
     */
    public function actionEdit(ParameterBag $parameterBag)
    {
        $tag = null;
        if ($tagUrl = $parameterBag->get('tag_url'))
        {
            /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
            $tag = $this->finder('XF:Tag')
                ->where('tag_url', $tagUrl)
                ->fetchOne();
        }

        if (!$tag)
        {
            return $this->error(\XF::phrase('requested_tag_not_found'), 404);
        }

        if (!$this->assertTagEditable($tag, $error))
        {
            return $this->noPermission($error);
        }

        /** @var \AVForums\TagEssentials\Repository\TagCategory $categoryRepo */
        $categoryRepo = $this->repository('AVForums\TagEssentials:TagCategory');
        $categories = $categoryRepo->getCategoryTitlePairs();

        $viewParams = [
            'tag' => $tag,
            'categories' => $categories
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\Edit', 'avForumsTagEss_tag_edit', $viewParams);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return Error|\XF\Mvc\Reply\Redirect
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionSave(ParameterBag $parameterBag)
    {
        $this->assertPostOnly();

        $tag = null;
        if ($tagUrl = $parameterBag->get('tag_url'))
        {
            /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
            $tag = $this->finder('XF:Tag')
                ->where('tag_url', $tagUrl)
                ->fetchOne();
        }

        if (!$tag)
        {
            return $this->error(\XF::phrase('requested_tag_not_found'), 404);
        }

        if (!$this->assertTagEditable($tag, $error))
        {
            return $this->noPermission($error);
        }

        /** @var \AVForums\TagEssentials\Repository\TagCategory $categoryRepo */
        $categoryRepo = $this->repository('AVForums\TagEssentials:TagCategory');
        $categories = $categoryRepo->getCategoryTitlePairs();

        if ($tag->canEditCategory())
        {
            $selectedCategory = $this->filter('tagess_category_id', 'str');
            if ($selectedCategory !== '' && !isset($categories[$selectedCategory]))
            {
                return $this->notFound(\XF::phrase('avForumsTagEss_requested_tag_category_not_found'));
            }
            $tag->tagess_category_id = $selectedCategory;
        }

        if ($tag->canEditWiki())
        {
            /** @var \XF\ControllerPlugin\Editor $editorPlugin */
            $editorPlugin = $this->plugin('XF:Editor');
            $tag->tagess_wiki_description = $editorPlugin->fromInput('tagess_wiki_description');
            $tag->tagess_wiki_tagline = $this->filter('tagess_wiki_tagline', 'str');
        }

        $tag->saveIfChanged();

        return $this->redirect($this->buildLink('tags', $tag));
    }

    /**
     * @param ParameterBag $parameterBag
     * @return Error|\XF\Mvc\Reply\Redirect|View
     */
    public function actionWiki(ParameterBag $parameterBag)
    {
        $tag = null;
        if ($tagUrl = $parameterBag->get('tag_url'))
        {
            $tag = $this->finder('XF:Tag')
                ->where('tag_url', $tagUrl)
                ->fetchOne();
        }

        if (!$tag)
        {
            return $this->error(\XF::phrase('requested_tag_not_found'), 404);
        }

        if ($this->options()->tagess_wikidescriptiononpage)
        {
            return $this->redirect($this->buildLink('tags', $tag));
        }

        $viewParams = [
            'tag' => $tag
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\Wiki', 'avForumsTagEss_wiki', $viewParams);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return Error|View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionTopUsers(ParameterBag $parameterBag)
    {
        if (!$this->options()->tagess_topUsers)
        {
            throw $this->exception($this->noPermission());
        }

        $tag = null;
        if ($tagUrl = $parameterBag->get('tag_url'))
        {
            /** @var \XF\Entity\Tag $tag */
            $tag = $this->finder('XF:Tag')
                ->where('tag_url', $tagUrl)
                ->fetchOne();
        }

        if (!$tag)
        {
            return $this->error(\XF::phrase('requested_tag_not_found'), 404);
        }

        /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
        $tagRepo = $this->repository('XF:Tag');
        list($topUsers, $extraDataRef) = $tagRepo->getTopUsers($tag);

        $viewParams = [
            'tag' => $tag,
            'topUsers' => $topUsers,
            'extraDataRef' => $extraDataRef
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\TopUsers', 'avForumsTagEss_top_users', $viewParams);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return Error|View
     */
    public function actionPreview(ParameterBag $parameterBag)
    {
        $tag = null;
        if ($tagUrl = $parameterBag->get('tag_url'))
        {
            /** @var \XF\Entity\Tag $tag */
            $tag = $this->finder('XF:Tag')
                ->where('tag_url', $tagUrl)
                ->fetchOne();
        }

        if (!$tag)
        {
            return $this->error(\XF::phrase('requested_tag_not_found'), 404);
        }

        $viewParams = [
            'tag' => $tag
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\Preview', 'avForumsTagEss_tag_preview', $viewParams);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return Error|\XF\Mvc\Reply\Redirect|View
     * @throws \XF\PrintableException
     */
    public function actionWatch(ParameterBag $parameterBag)
    {
        $tag = null;
        if ($tagUrl = $parameterBag->get('tag_url'))
        {
            /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
            $tag = $this->finder('XF:Tag')
                ->where('tag_url', $tagUrl)
                ->fetchOne();
        }

        if (!$tag)
        {
            return $this->error(\XF::phrase('requested_tag_not_found'), 404);
        }

        if (!$tag->canWatch($error))
        {
            return $this->noPermission($error);
        }

        $visitor = \XF::visitor();

        /** @var \AVForums\TagEssentials\Repository\TagWatch $watchRepo */
        $watchRepo = $this->repository('AVForums\TagEssentials:TagWatch');
        $tagWatch = $this->finder('AVForums\TagEssentials:TagWatch')
            ->where('user_id', $visitor->user_id)
            ->where('tag_id', $tag->tag_id)
            ->fetchOne();

        if ($this->isPost())
        {
            if ($this->filter('stop', 'bool'))
            {
                $newState = 'delete';
            }
            else if ($this->filter('email_subscribe', 'bool'))
            {
                $newState = 'watch_email';
            }
            else
            {
                $newState = 'watch_no_email';
            }

            if (!$tagWatch && $newState !== 'delete')
            {
                /** @var \AVForums\TagEssentials\Entity\TagWatch $tagWatch */
                $tagWatch = $this->em()->create('AVForums\TagEssentials:TagWatch');
                $tagWatch->user_id = $visitor->user_id;
                $tagWatch->tag_id = $tag->tag_id;
                $tagWatch->send_alert = true;
            }

            $watchRepo->setWatchState($tagWatch, $newState);

            $redirect = $this->redirect($this->buildLink('tags', $tag));
            $redirect->setJsonParam('switchKey', $newState === 'delete' ? 'watch' : 'unwatch');
            return $redirect;
        }

        $viewParams = [
            'tag' => $tag,
            'isWatched' => $tagWatch ? true : false
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\Watch', 'avForumsTagEss_tag_watch', $viewParams);
    }
}