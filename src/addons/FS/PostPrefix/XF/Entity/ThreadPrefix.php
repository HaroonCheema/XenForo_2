<?php

namespace FS\PostPrefix\XF\Entity;

class ThreadPrefix extends XFCP_ThreadPrefix
{
    protected function _postDelete()
    {
        parent::_postDelete();

        $this->db()->delete('fs_post_prefixes', 'prefix_id = ?', $this->prefix_id);
    }
}