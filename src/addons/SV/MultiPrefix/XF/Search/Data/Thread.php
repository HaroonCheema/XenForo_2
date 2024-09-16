<?php

namespace SV\MultiPrefix\XF\Search\Data;

class Thread extends XFCP_Thread
{
    /**
     * @param \SV\MultiPrefix\XF\Entity\Thread $entity
     *
     * @return array
     */
    protected function getMetaData(\XF\Entity\Thread $entity)
    {
        /** @var \SV\MultiPrefix\XF\Entity\Thread $entity */

        $metaData = parent::getMetaData($entity);

        if ($entity->sv_prefix_ids)
        {
            $metaData['prefix'] = $entity->sv_prefix_ids;
        }

        return $metaData;
    }
}
