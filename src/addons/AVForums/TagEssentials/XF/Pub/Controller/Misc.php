<?php

namespace AVForums\TagEssentials\XF\Pub\Controller;

/**
 * Class Misc
 *
 * Extends \XF\Pub\Controller\Misc
 *
 * @package AVForums\TagEssentials\XF\Pub\Controller
 */
class Misc extends XFCP_Misc
{
    /**
     * @return \XF\Mvc\Reply\Message|\XF\Mvc\Reply\View
     */
    public function actionTagessAddFromTitle()
    {
        $options = $this->options();

        if (!$options->enableTagging)
        {
            return $this->noPermission();
        }

        if (!$options->tagessSuggestTags)
        {
            return $this->message(\XF::phrase('no_results_found'));
        }

        $nodeId = $this->filter('node_id', 'uint');
        $title = $this->filter('title', 'str');

        /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
        $tagRepo = $this->repository('XF:Tag');
        $tagsFromTitle = $tagRepo->getTagsFromTitle($title, $nodeId);

        $view = $this->view();
        $view->setJsonParams([
            'results' => $tagsFromTitle,
            'title' => $title,
        ]);

        return $view;
    }

    /**
     * @return \XF\Mvc\Reply\Message|\XF\Mvc\Reply\View
     */
    public function actionTagessAddFromPrefix()
    {
        $options = $this->options();

        if (!$options->enableTagging)
        {
            return $this->noPermission();
        }

        //if (!$options->tagessSuggestTags)
        //{
        //    return $this->message(\XF::phrase('no_results_found'));
        //}

        $prefixIds = $this->filter('prefix_id', 'uint');
        if (!$prefixIds)
        {
            $prefixIds = $this->filter('prefix_id', 'array-uint');
            $prefixIds = \array_unique(\array_filter($prefixIds));
        }
        else
        {
            $prefixIds = [$prefixIds];
        }

        $tags = [];
        if ($prefixIds)
        {
            $prefixes = \XF::finder('XF:ThreadPrefix')->whereIds($prefixIds)->fetch();
            if ($prefixes->count())
            {
                /** @var \AVForums\TagEssentials\XF\Entity\ThreadPrefix $prefix */
                foreach ($prefixes as $prefix)
                {
                    if ($prefix->tagess_tags)
                    {
                        $tags = \array_merge($tags, $prefix->tagess_tags);
                    }
                }
            }
        }

        $view = $this->view();
        $view->setJsonParams([
            'results' => $tags,
        ]);

        return $view;
    }

    /**
     * @return \XF\Mvc\Reply\View
     */
    public function actionSynonymAutoComplete()
    {
        if (!$this->options()->enableTagging)
        {
            return $this->noPermission();
        }

        /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
        $tagRepo = $this->repository('XF:Tag');

        $tagId = $this->filter('tag', 'uint');
        $q = $this->filter('q', 'str');
        $q = $tagRepo->normalizeTag($q);

        if (strlen($q) >= 2)
        {
            $tags = $tagRepo->getSynonymTagAutoCompleteResults($q, $tagId);

            $results = [];
            foreach ($tags AS $tag)
            {
                $results[] = [
                    'id' => $tag->tag,
                    'icon' => null,
                    'text' => $tag->tag,
                    'q' => $q,
                ];
            }
        }
        else
        {
            $results = [];
        }
        $view = $this->view();
        $view->setJsonParam('results', $results);
        return $view;
    }
}