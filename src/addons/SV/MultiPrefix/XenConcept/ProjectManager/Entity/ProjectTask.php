<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Entity;


use SV\MultiPrefix\Behavior\MultiPrefixable;
use SV\MultiPrefix\ILinkablePrefix;
use XF\Mvc\Entity\Structure;

/**
 * @property int[] $sv_prefix_ids
 * @property \SV\MultiPrefix\Entity\XCProjectPrefixLink PrefixesLink
 */
class ProjectTask extends XFCP_ProjectTask implements ILinkablePrefix
{
    /**
     * @return array
     */
    public function getSvPrefixIds()
    {
        return MultiPrefixable::getSvPrefixIds($this);
    }

    public function getSvPrefixFilterLink(int $prefixId, string $linkType = ''): string
    {
        $project = $this->Project;
        return $project ? \XF::app()->router()->buildLink($linkType . 'projects/tasks', $project, ['prefix_id' => $prefixId]) : '';
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->relations['PrefixesLink'] = [
            'entity'        => 'SV\MultiPrefix:XCProjectTaskPrefixLink',
            'type'          => self::TO_MANY,
            'conditions'    => 'project_task_id',
            'key'           => 'prefix_id',
            'cascadeDelete' => true
        ];

        $structure->behaviors['SV\MultiPrefix:MultiPrefixable'] = [
            'containerIdField' => 'project_id',
            'containerRelation' => 'Project',
            'containerPhrase' => 'xcpm_project',
            'linkTable' => 'xf_sv_xc_project_manager_project_task_prefix_link',
        ];
        MultiPrefixable::addMultiPrefixFields($structure);

        return $structure;
    }
}
