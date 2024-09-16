<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Api\Controller;

class ProjectTasks extends XFCP_ProjectTasks
{
    /**
     * @param \SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $project
     * @return \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask\Create|\XenConcept\ProjectManager\Service\ProjectTask\Create
     */
    protected function setupProjectTask(\XenConcept\ProjectManager\Entity\ProjectItem $project)
    {
        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask\Create $creator */
        $creator = parent::setupProjectTask($project);
        $task = $creator->getTask();
        $task->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $task->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        $prefixIds = $this->filter('sv_prefix_ids', '?array-uint') ?? $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds AS $key => $prefixId)
            {
                if (!$prefixId || !$project->isPrefixUsable($prefixId))
                {
                    unset($prefixIds[$key]);
                }
            }

            $creator->setPrefixIds($prefixIds);
        }

        return $creator;
    }
}