<?php

namespace AVForums\TagEssentials\XF\Entity;

use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Structure;

/**
 * @property string[] tagess_tags
 * @property ArrayCollection|\XF\Entity\Tag[] DefaultTags
 */
class Forum extends XFCP_Forum
{
    protected function _postSave()
    {
        parent::_postSave();

        if ($this->tagess_tags && $this->isChanged('tagess_tags'))
        {
            /** @var \XF\Repository\Tag $tagRepo */
            $tagRepo = \XF::repository('XF:Tag');
            $tags = $tagRepo->getTags($this->tagess_tags, $notFound);
            /** @var \XF\Entity\Tag $tag */
            foreach($tags as $tag)
            {
                $tag->permanent = 1;
                $tag->saveIfChanged($aves, true, false);
            }
            foreach($notFound as $tagName)
            {
                $tag = \XF::app()->em()->create('XF:Tag');
                $tag->tag = $tagName;
                $tag->permanent = 1;
                $tag->saveIfChanged($aves, true, false);
            }
        }
    }

    public function isForumPrefixesTagged()
    {
        if (!\XF::options()->enableTagging)
        {
            return false;
        }
        /** @var \AVForums\TagEssentials\XF\Entity\ThreadPrefix $prefix */
        foreach ($this->prefixes as $prefix)
        {
            if ($prefix->tagess_tags)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param bool $recusive
     * @return string[]
     */
    public function getRecursiveDefaultTags($recusive)
    {
        if (!\XF::options()->enableTagging)
        {
            return [];
        }

        if (!$recusive)
        {
            $this->tagess_tags ?: [];
        }

        $breadcrumbs = $this->getBreadcrumbs(false);
        $nodeIds = [];
        $tags = [];
        foreach ($breadcrumbs AS $breadcrumb)
        {
            if (!empty($breadcrumb['node_id']))
            {
                $nodeIds[] = $breadcrumb['node_id'];
            }
        }

        if ($nodeIds)
        {
            $forumFinder = $this->finder('XF:Forum')
                                ->where('node_id', $nodeIds)
                                ->where('tagess_tags', '<>', null);
            $forums = $forumFinder->fetch();

            if ($forums->count())
            {
                $tags = [];

                /** @var \AVForums\TagEssentials\XF\Entity\Forum $forum */
                foreach ($forums AS $forum)
                {
                    foreach ($forum->tagess_tags AS $tag)
                    {
                        $tags[] = $tag;
                    }
                }
            }
        }

        return array_merge($this->tagess_tags ?: [], $tags);
    }

    /**
     * @return AbstractCollection|\XF\Entity\Tag[]
     */
    public function getDefaultTags()
    {
        if (!$this->tagess_tags)
        {
            return new ArrayCollection([]);
        }

        return $this->finder('XF:Tag')
            ->where('tag', $this->tagess_tags)
            ->fetch();
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        /** @noinspection PhpDeprecationInspection */
        $structure->columns['tagess_tags'] = ['type' => self::SERIALIZED_ARRAY, 'default' => null, 'nullable' => true];
        $structure->getters['DefaultTags'] = true;

        return $structure;
    }
}