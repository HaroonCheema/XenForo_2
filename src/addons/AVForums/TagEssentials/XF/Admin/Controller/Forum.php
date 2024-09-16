<?php

namespace AVForums\TagEssentials\XF\Admin\Controller;

use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\FormAction;

/**
 * Class Forum
 *
 * Extends \XF\Admin\Controller\Forum
 *
 * @package AVForums\TagEssentials\XF\Admin\Controller
 */
class Forum extends XFCP_Forum
{
    /**
     * @param FormAction              $form
     * @param \XF\Entity\Node         $node
     * @param \XF\Entity\AbstractNode| \AVForums\TagEssentials\XF\Entity\Forum $data
     */
    protected function saveTypeData(FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
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

            $form->apply(function() use ($form, $tagsArr, $tags, $data) {
                foreach ($tagsArr AS $newTagToCreate)
                {
                    /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
                    $tag = $this->em()->create('XF:Tag');
                    $tag->tag = $newTagToCreate;
                    $tag->permanent = true;
                    $tag->save(true, false);
                }

                $data->tagess_tags = $tags->toArray();
                $data->save(true, $form->isUsingTransaction() ? false : true);
            });
        }
        else
        {
            $data->tagess_tags = [];
        }

        parent::saveTypeData($form, $node, $data);
    }
}