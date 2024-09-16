<?php

namespace SV\MultiPrefix\XFRM\Search\Data;

class ResourceItem extends XFCP_ResourceItem
{
    /**
     * @param \SV\MultiPrefix\XFRM\Entity\ResourceItem $entity
     * @return array
     */
    protected function getMetaData(\XFRM\Entity\ResourceItem $entity)
    {
        /** @var \SV\MultiPrefix\XFRM\Entity\ResourceItem $entity */
        $metaData = parent::getMetaData($entity);

        if ($entity->sv_prefix_ids)
        {
            $metaData['resprefix'] = $entity->sv_prefix_ids;
        }

        return $metaData;
    }
}
