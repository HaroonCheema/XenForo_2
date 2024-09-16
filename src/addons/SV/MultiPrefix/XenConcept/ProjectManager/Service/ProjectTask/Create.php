<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask;

use SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category;
use SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem;
use XenConcept\ProjectManager\Entity\ProjectTask;

class Create extends XFCP_Create
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
        /** @var ProjectTask $task */
        $task = $this->task;
        $task->sv_prefix_ids = $prefixIds;
        $prefixId = \count($prefixIds) !== 0 ? \reset($prefixIds) : 0;
        parent::setPrefix($prefixId);
    }
}