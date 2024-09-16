<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Api\Controller;

class ProjectItems extends XFCP_ProjectItems
{
    /**
     * @param \SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category $category
     * @return \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Create|\XenConcept\ProjectManager\Service\ProjectItem\Create
     */
    protected function setupProjectCreate(\XFRM\Entity\Category $category)
    {
        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Create $creator */
        $creator = parent::setupProjectCreate($category);
        $project = $creator->getProject();
        $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        $prefixIds = $this->filter('sv_prefix_ids', '?array-uint') ?? $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds AS $key => $prefixId)
            {
                if (!$prefixId || !$category->isPrefixUsable($prefixId))
                {
                    unset($prefixIds[$key]);
                }
            }

            $creator->setPrefixIds($prefixIds);
        }

        return $creator;
    }
}