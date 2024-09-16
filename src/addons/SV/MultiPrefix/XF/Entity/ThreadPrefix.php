<?php

namespace SV\MultiPrefix\XF\Entity;

class ThreadPrefix extends XFCP_ThreadPrefix
{
    protected function _postDelete()
    {
        parent::_postDelete();

        $this->db()->delete('xf_sv_thread_prefix_link', 'prefix_id = ?', $this->prefix_id);
    }
}