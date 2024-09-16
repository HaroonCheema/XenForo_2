<?php

namespace SV\MultiPrefix\XF\Service\Feed;

/**
 * Extends \XF\Service\Feed\Feeder
 */
class Feeder extends XFCP_Feeder
{
    protected function setupThreadCreate(array $entry)
    {
        /** @var \SV\MultiPrefix\XF\Entity\Feed $feed */
        $feed = $this->feed;
        /** @var \SV\MultiPrefix\XF\Service\Thread\Creator $creator */
        $creator = parent::setupThreadCreate($entry);

        if ($feed->prefix_id && $feed->sv_prefix_ids)
        {
            $creator->setPrefixIds($feed->sv_prefix_ids);
        }

        return $creator;
    }
}