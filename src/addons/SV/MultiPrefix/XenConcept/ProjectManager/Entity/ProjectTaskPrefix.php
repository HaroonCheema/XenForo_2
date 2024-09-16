<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Entity;

class ProjectTaskPrefix extends XFCP_ProjectTaskPrefix
{
    protected function _postDelete()
    {
        parent::_postDelete();

        $this->db()->delete('xf_sv_xc_project_manager_project_task_prefix_link', 'prefix_id = ?', $this->prefix_id);
    }
}