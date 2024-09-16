<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem;

use SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category;
use SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem;

class Create extends XFCP_Create
{
    protected function setupProjectThreadCreation(\XF\Entity\Forum $forum)
    {
        /** @var \SV\MultiPrefix\XF\Service\Thread\Creator $creator */
        $creator = parent::setupProjectThreadCreation($forum);

        // add-on Truonglv/ThreadResource forces this to return null which is very unexpected
        if ($creator)
        {
            /** @var Category $category */
            $category = $this->category;
            $creator->setPrefixIds($category->sv_thread_prefix_ids);
        }

        return $creator;
    }

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
        /** @var ProjectItem $project */
        $project = $this->project;
        $project->sv_prefix_ids = $prefixIds;
        $prefixId = \count($prefixIds) !== 0 ? \reset($prefixIds) : 0;
        parent::setPrefix($prefixId);
    }
}