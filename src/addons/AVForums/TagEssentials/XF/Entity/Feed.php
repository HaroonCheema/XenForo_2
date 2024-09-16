<?php

namespace AVForums\TagEssentials\XF\Entity;

use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Structure;

/**
 * @property string[] tagess_tags
 * @property ArrayCollection|\XF\Entity\Tag[] DefaultTags
 */
class Feed extends XFCP_Feed
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