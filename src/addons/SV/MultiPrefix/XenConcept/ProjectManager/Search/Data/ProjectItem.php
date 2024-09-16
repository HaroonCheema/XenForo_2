<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Search\Data;

class ProjectItem extends XFCP_ProjectItem
{
    /**
     * @param \SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $entity
     * @return array
     */
    protected function getMetaData(\XenConcept\ProjectManager\Entity\ProjectItem $entity)
    {
        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $entity */
        $metaData = parent::getMetaData($entity);

        if ($entity->sv_prefix_ids)
        {
            $metaData['projectprefix'] = $entity->sv_prefix_ids;
        }

        return $metaData;
    }
}
