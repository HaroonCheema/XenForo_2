<?php

namespace SV\MultiPrefix\XFRM\Entity;

class ResourcePrefix extends XFCP_ResourcePrefix
{
    protected function _postDelete()
    {
        parent::_postDelete();

        $this->db()->delete('xf_sv_resource_prefix_link', 'prefix_id = ?', $this->prefix_id);
    }
}