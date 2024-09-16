<?php

namespace SV\MultiPrefix\DBTech\Shop\Service\Item;

use SV\MultiPrefix\DBTech\Shop\Entity\Item;

class Move extends XFCP_Move
{
    /**
     * @param int[] $prefixIds
     */
    public function setPrefixIds(array $prefixIds)
    {
        /** @var Item $item */
        $item = $this->item;
        $item->sv_prefix_ids = $prefixIds;
        $prefixId = \count($prefixIds) !== 0 ? \reset($prefixIds) : 0;
        parent::setPrefix($prefixId);
    }
}