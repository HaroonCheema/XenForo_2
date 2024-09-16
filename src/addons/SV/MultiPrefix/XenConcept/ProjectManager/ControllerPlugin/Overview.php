<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\ControllerPlugin;

use XenConcept\ProjectManager\Finder\ProjectItem;

class Overview extends XFCP_Overview
{
    /**
     * @param ProjectItem $projectFinder
     *
     * @param array $filters
     */
    public function applyProjectFilters(ProjectItem $projectFinder, array $filters)
    {
        // this class requires a high execution order to ensure the node list is correctly extracted when other add-ons are around
        $prefixFilter = $filters['prefix_id'] ?? null;
        unset($filters['prefix_id']);

        parent::applyProjectFilters($projectFinder, $filters);

        if ($prefixFilter !== null)
        {
            /** @var \SV\MultiPrefix\XFRM\Finder\ResourceItem $projectFinder */
            $projectFinder->hasPrefixes($prefixFilter);
        }
    }

    /**
     * @return array
     */
    public function getProjectFilterInput()
    {
        $filters = parent::getProjectFilterInput();

        if ($this->request->exists('prefix_id'))
        {
            if ($prefixId = $this->filter('prefix_id', 'uint'))
            {
                $filters['prefix_id'] = [$prefixId];
            }
            else if ($prefixId = $this->filter('prefix_id', 'array-uint'))
            {
                $filters['prefix_id'] = $prefixId;
            }
        }

        return $filters;
    }
}
