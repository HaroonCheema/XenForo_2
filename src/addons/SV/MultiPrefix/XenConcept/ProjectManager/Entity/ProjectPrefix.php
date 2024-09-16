<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Entity;

class ProjectPrefix extends XFCP_ProjectPrefix
{
    protected function _postDelete()
    {
        parent::_postDelete();

        $this->db()->delete('xf_sv_xc_project_manager_project_prefix_link', 'prefix_id = ?', $this->prefix_id);
    }
}