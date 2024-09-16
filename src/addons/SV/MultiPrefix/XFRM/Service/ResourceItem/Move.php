<?php

namespace SV\MultiPrefix\XFRM\Service\ResourceItem;

use SV\MultiPrefix\XFRM\Entity\ResourceItem;

class Move extends XFCP_Move
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
        /** @var ResourceItem $resource */
        $resource = $this->resource;
        $resource->sv_prefix_ids = $prefixIds;
        $prefixId = \count($prefixIds) !== 0 ? \reset($prefixIds) : 0;
        parent::setPrefix($prefixId);
    }
}