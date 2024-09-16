<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask;

use SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjecTask;
use XenConcept\ProjectManager\Entity\ProjectTask;

class Edit extends XFCP_Edit
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