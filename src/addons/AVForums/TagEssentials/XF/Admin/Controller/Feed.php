<?php

namespace AVForums\TagEssentials\XF\Admin\Controller;



use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\FormAction;

/**
 * Extends \XF\Admin\Controller\Feed
 */
class Feed extends XFCP_Feed
{
    /**
     * @param \XF\Entity\Feed|\AVForums\TagEssentials\XF\Entity\Feed $feed
     * @return FormAction
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function feedSaveProcess(\XF\Entity\Feed $feed)
    {
        $form = parent::feedSaveProcess($feed);

        /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
        $tagRepo = $this->repository('XF:Tag');

        $tagList = $this->filter('tagess_tags', 'str');
        $tags = new ArrayCollection($tagRepo->splitTagList($tagList));
        $tags = $tags->filter(function ($tag) use ($tagRepo)
        {
            if ($tagRepo->isValidTag($tag))
            {
                return true;
            }

            return false;
        });

        if ($tags->count())
        {
            $tagsArr = $tags->toArray();
            $existingTags = $this->finder('XF:Tag')
                                 ->where('tag', $tagsArr)
                                 ->fetch();

            /** @var \AVForums\TagEssentials\XF\Entity\Tag $existingTag */
            foreach ($existingTags AS $existingTag)
            {
                $tagsArr = array_diff($tagsArr, [$existingTag->tag]);
            }

            $form->apply(function() use ($form, $tagsArr, $tags, $feed) {
                foreach ($tagsArr AS $newTagToCreate)
                {
                    /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
                    $tag = $this->em()->create('XF:Tag');
                    $tag->tag = $newTagToCreate;
                    $tag->permanent = true;
                    $tag->save(true, false);
                }

                $feed->tagess_tags = $tags->toArray();
                $feed->save(true, $form->isUsingTransaction() ? false : true);
            });
        }
        else
        {
            $feed->tagess_tags = [];
        }

        return $form;
    }
}