<?php

namespace SV\MultiPrefix\XF\Service\Post;

use SV\MultiPrefix\XF\Entity\Thread;

/**
 * Extends \XF\Service\Post\Mover
 */
class Mover extends XFCP_Mover
{
    /**
     * @param $prefixId
     */
    public function setPrefix($prefixId)
    {
        if (\is_array($prefixId))
        {
            $this->setPrefixIds($prefixId);
        }
        else
        {
            parent::setPrefix($prefixId);
        }
    }

    /**
     * @param int[] $prefixIds
     */
    public function setPrefixIds(array $prefixIds)
    {
        $this->prefixId = $prefixIds;
    }

    public function move($sourcePostsRaw)
    {
        /** @var Thread $target */
        $target = $this->target;
        if ($target && !$target->thread_id && $this->prefixId !== null)
        {
            $target->sv_prefix_ids = $this->prefixId;
            $this->prefixId = null;
        }
        return parent::move($sourcePostsRaw);
    }
}