<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Api\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;

class ProjectTask extends XFCP_ProjectTask
{

    /**
     * @param \XenConcept\ProjectManager\Entity\ProjectItem|\SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectTask $task
     * @return \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask\Edit|\XenConcept\ProjectManager\Service\ProjectTask\Edit
     */
    protected function setupTaskEdit(\XenConcept\ProjectManager\Entity\ProjectTask $task)
    {
        $originalPrefixes = \array_fill_keys(MultiPrefixable::getPreviousPrefixIds($task), true);
        $task->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $task->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask\Edit $editor */
        $editor = parent::setupTaskEdit($task);

        $prefixIds = $this->filter('sv_prefix_ids', '?array-uint') ?? $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds as $key => $prefixId)
            {
                if (!$prefixId || (empty($originalPrefixes[$prefixId]) && !$task->Project->isPrefixUsable($prefixId)))
                {
                    unset($prefixIds[$key]);
                }
            }

            $editor->setPrefixIds($prefixIds);
        }

        return $editor;
    }

}