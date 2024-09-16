<?php

namespace SV\MultiPrefix\XFRM\Service\ResourceItem;

use SV\MultiPrefix\XFRM\Entity\Category;
use SV\MultiPrefix\XFRM\Entity\ResourceItem;

class Create extends XFCP_Create
{
    protected function setupResourceThreadCreation(\XF\Entity\Forum $forum)
    {
        /** @var \SV\MultiPrefix\XF\Service\Thread\Creator $creator */
        $creator = parent::setupResourceThreadCreation($forum);

        // add-on Truonglv/ThreadResource forces this to return null which is very unexpected
        if ($creator)
        {
            /** @var Category $category */
            $category = $this->category;
            $creator->setPrefixIds($category->sv_thread_prefix_ids);
        }

        return $creator;
    }

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