<?php

namespace AVForums\TagEssentials\XF\Job;

/**
 * Class ThreadAction
 *
 * @package AVForums\TagEssentials\XF\Job
 */
class ThreadAction extends XFCP_ThreadAction
{
    /**
     * @param \XF\Entity\Thread $thread
     */
    protected function applyExternalThreadChange(\XF\Entity\Thread $thread)
    {
        parent::applyExternalThreadChange($thread);

        $tagsToAdd = $this->getActionValue('add_tags');
        $tagsToRemove = $this->getActionValue('remove_tags');
        $tagsFromTitle = $this->getActionValue('auto_tag_from_title');
        if ($tagsToAdd || $tagsToRemove || $tagsFromTitle)
        {
            /** @var \AVForums\TagEssentials\XF\Service\Tag\Changer $tagger */
            $tagger = \XF::service('XF:Tag\Changer', 'thread', $thread);

            if ($tagsFromTitle)
            {
                /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
                $tagRepo = \XF::repository('XF:Tag');
                $tagsFromTitle = $tagRepo->getTagsFromTitle($thread->title, $thread->node_id);
                $tagger->_addTags($tagsFromTitle);
            }

            $tagger->_addTags($tagsToAdd);
            $tagger->_removeTags($tagsToRemove);

            if ($tagger->_hasChanges())
            {
                $tagger->save(false);
            }
        }
    }
}