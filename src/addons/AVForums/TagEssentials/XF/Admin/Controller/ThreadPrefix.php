<?php

namespace AVForums\TagEssentials\XF\Admin\Controller;

use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\FormAction;

/**
 * Class Forum
 *
 * Extends \XF\Admin\Controller\ThreadPrefix
 *
 * @package AVForums\TagEssentials\XF\Admin\Controller
 */
class ThreadPrefix extends XFCP_ThreadPrefix
{
    /**
     * @param FormAction                $form
     * @param \XF\Entity\AbstractPrefix|\AVForums\TagEssentials\XF\Entity\ThreadPrefix $prefix
     */
    protected function saveAdditionalData(FormAction $form, \XF\Entity\AbstractPrefix $prefix)
    {
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

            $form->apply(function() use ($form, $tagsArr, $tags, $prefix) {
                foreach ($tagsArr AS $newTagToCreate)
                {
                    /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
                    $tag = $this->em()->create('XF:Tag');
                    $tag->tag = $newTagToCreate;
                    $tag->permanent = true;
                    $tag->save(true, false);
                }

                $prefix->tagess_tags = $tags->toArray();
                $prefix->save(true, $form->isUsingTransaction() ? false : true);
            });
        }
        else
        {
            $prefix->tagess_tags = [];
        }

        parent::saveAdditionalData($form, $prefix);
    }
}