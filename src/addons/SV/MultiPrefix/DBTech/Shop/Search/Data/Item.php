<?php

namespace SV\MultiPrefix\DBTech\Shop\Search\Data;

class Item extends XFCP_Item
{
	/**
	 * @param \DBTech\Shop\Entity\Item $entity
	 *
	 * @return array
	 */
    protected function getMetaData(\DBTech\Shop\Entity\Item $entity): array
    {
        /** @var \SV\MultiPrefix\DBTech\Shop\Entity\Item $entity */
        $metaData = parent::getMetaData($entity);

        if ($entity->sv_prefix_ids)
        {
            $metaData['resprefix'] = $entity->sv_prefix_ids;
        }

        return $metaData;
    }
}
