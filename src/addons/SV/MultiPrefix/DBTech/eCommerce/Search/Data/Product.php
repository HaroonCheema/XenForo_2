<?php

namespace SV\MultiPrefix\DBTech\eCommerce\Search\Data;

class Product extends XFCP_Product
{
    /**
     * @param \DBTech\eCommerce\Entity\Product $entity
     * @return array
     */
    protected function getMetaData(\DBTech\eCommerce\Entity\Product $entity): array
    {
        /** @var \SV\MultiPrefix\DBTech\eCommerce\Entity\Product $entity */
        $metaData = parent::getMetaData($entity);

        if ($entity->sv_prefix_ids)
        {
            $metaData['resprefix'] = $entity->sv_prefix_ids;
        }

        return $metaData;
    }
}
