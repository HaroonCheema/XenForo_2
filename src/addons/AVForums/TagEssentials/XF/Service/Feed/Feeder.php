<?php

namespace AVForums\TagEssentials\XF\Service\Feed;



/**
 * Extends \XF\Service\Feed\Feeder
 */
class Feeder extends XFCP_Feeder
{
    protected function setupThreadCreate(array $entry)
    {
        /** @var \AVForums\TagEssentials\XF\Entity\Feed $feed */
        $feed = $this->feed;
        $creator = parent::setupThreadCreate($entry);

        $creator->setTags($feed->tagess_tags);

        return $creator;
    }
}