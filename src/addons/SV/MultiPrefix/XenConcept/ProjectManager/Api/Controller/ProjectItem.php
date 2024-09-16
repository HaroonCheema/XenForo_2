<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Api\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;

class ProjectItem extends XFCP_ProjectItem
{
    /**
     * @param \XenConcept\ProjectManager\Entity\ProjectItem|\SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $project
     * @return \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Edit|\XenConcept\ProjectManager\Service\ProjectItem\Edit
     */
    protected function setupProjectEdit(\XenConcept\ProjectManager\Entity\ProjectItem $project)
    {
        $originalPrefixes = \array_fill_keys(MultiPrefixable::getPreviousPrefixIds($project), true);
        $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Edit $editor */
        $editor = parent::setupProjectEdit($project);

        $prefixIds = $this->filter('sv_prefix_ids', '?array-uint') ?? $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds as $key => $prefixId)
            {
                if (!$prefixId || (empty($originalPrefixes[$prefixId]) && !$project->Category->isPrefixUsable($prefixId)))
                {
                    unset($prefixIds[$key]);
                }
            }

            $editor->setPrefixIds($prefixIds);
        }

        return $editor;
    }
}