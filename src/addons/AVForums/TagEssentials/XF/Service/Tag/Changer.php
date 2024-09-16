<?php

namespace AVForums\TagEssentials\XF\Service\Tag;

use XF\Mvc\Entity\Entity;

/**
 * Class Changer
 * Extends \XF\Service\Tag\Changer
 *
 * @package AVForums\TagEssentials\XF\Service\Tag
 */
class Changer extends XFCP_Changer
{
    protected $blackListedTags   = [];
    protected $parentSynonymTags = [];

    /** @var Entity */
    protected $context;

    public function __construct(\XF\App $app, $contentType, Entity $context)
    {
        parent::__construct($app, $contentType, $context);

        if ($this->contentId && $context)
        {
            $this->context = $context;
        }
    }
    /**
     * @param string[]|string $tagList
     * @param bool  $create
     * @param bool  $checkBlacklist
     */
    public function _addTags($tagList, $create = true, $checkBlacklist = true)
    {
        if (!is_array($tagList))
        {
            $tagList = $this->splitTags($tagList);
        }

        if (!$tagList)
        {
            return;
        }

        /** @var \AVForums\TagEssentials\Repository\Blacklist $blacklistRepo */
        $blacklistRepo = $this->repository('AVForums\TagEssentials:Blacklist');

        $addTags = $this->tagRepo->getTags($tagList, $createTags);
        foreach ($addTags AS $tag)
        {
            if ($checkBlacklist && $blacklistRepo->isTagBlacklisted($tag, $this->context))
            {
                continue;
            }
            $id = $tag->tag_id;
            if (isset($this->existingTags[$id]) && !isset($this->removeTags[$id]))
            {
                continue;
            }

            $this->addTags[$id] = $tag->tag;
        }

        if ($create)
        {
            foreach ($createTags AS $create)
            {
                if ($checkBlacklist && $blacklistRepo->isTagBlacklisted($create, $this->context))
                {
                    continue;
                }
                $this->createTags[$create] = $create;

                if (!$this->tagRepo->isValidTag($create))
                {
                    $this->invalidCreateTags[$create] = $create;
                }
            }
        }
    }

    /**
     * @param string[]|string $tagList
     */
    public function _removeTags($tagList)
    {
        if (!is_array($tagList))
        {
            $tagList = $this->splitTags($tagList);
        }

        if (!$tagList)
        {
            return;
        }

        $removeTags = $this->tagRepo->getTags($tagList, $createTags);
        foreach ($removeTags AS $tag)
        {
            $id = $tag->tag_id;
            if (isset($this->existingTags[$id]))
            {
                $this->removeTags[$id] = $tag->tag;
            }
            else if (isset($this->addTags[$id]))
            {
                unset($this->addTags[$id]);
            }
            else if (isset($this->createTags[$id]))
            {
                unset($this->createTags[$id]);
            }
        }
    }

    public function _hasChanges()
    {
        return (bool)$this->addTags || (bool)$this->createTags || (bool)$this->removeTags;
    }

    protected function checkForErrors()
    {
        parent::checkForErrors();

        /** @var \AVForums\TagEssentials\Repository\Blacklist $blacklistRepo */
        $blacklistRepo = $this->repository('AVForums\TagEssentials:Blacklist');

        $blacklist = $this->blackListedTags;
        foreach ($this->addTags AS $tagId => $tag)
        {
            $tagEntity = \XF::app()->find('XF:Tag', $tagId);
            if ($tagEntity && $blacklistRepo->isTagBlacklisted($tagEntity, $this->context))
            {
                $blacklist[$tag] = true;
            }
        }
        foreach ($this->createTags AS $tag)
        {
            if ($blacklistRepo->isTagBlacklisted($tag, $this->context))
            {
                $blacklist[$tag] = true;
            }
        }
        foreach($this->parentSynonymTags as $tag => $filler)
        {
            unset($blacklist[$tag]);
        }

        if ($blacklist)
        {
            $blacklist = array_keys($blacklist);
            $this->errors['blacklist'] = \XF::phrase('avForumsTagEss_tags_are_blacklisted', ['tags' => implode(', ', $blacklist)]);
        }

        if (!empty($this->errors['invalidCreate']) && $this->app->options()->tagess_blockNumberTags)
        {
            $invalidCreate = $this->errors['invalidCreate'];
            if ($invalidCreate instanceof \XF\Phrase && $invalidCreate->getName() === 'some_tags_not_valid_please_change_x')
            {
                $this->errors['invalidCreate'] = \XF::phrase('avForumsTagEss_some_tags_not_valid_please_change_x', [
                    'tags' => implode(', ', $this->invalidCreateTags)
                ]);
            }
        }
    }

    /**
     * @param      $tagList
     * @param bool $ignoreNonRemovable
     */
    public function setTags($tagList, $ignoreNonRemovable = false)
    {
        parent::setTags($tagList, $ignoreNonRemovable);

        $tagsIds = array_keys($this->addTags);
        $synonyms = $this->finder('AVForums\TagEssentials:TagSynonym')
            ->where('tag_id', $tagsIds)
            ->with('Tag', true)
            ->with('ParentTag', true)
            ->fetch();

        /** @var \AVForums\TagEssentials\Repository\Blacklist $blacklistRepo */
        $blacklistRepo = $this->repository('AVForums\TagEssentials:Blacklist');

        /** @var \AVForums\TagEssentials\Entity\TagSynonym $synonym */
        foreach ($synonyms AS $synonym)
        {
            $tag = $synonym->Tag;
            $parentTagId = $synonym->parent_tag_id;
            $parentTag = $synonym->ParentTag->tag;
            if ($blacklistRepo->isTagBlacklisted($tag, $this->context))
            {
                $this->blackListedTags[$tag->tag] = true;
            }
            if (!isset($this->addTags[$parentTagId]))
            {
                $this->parentSynonymTags[$parentTag] = true;
            }
            $this->addTags[$parentTagId] = $parentTag;
            unset($this->addTags[$synonym->tag_id]);
        }
    }
}