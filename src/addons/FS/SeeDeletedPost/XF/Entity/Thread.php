<?php

namespace FS\SeeDeletedPost\XF\Entity;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
    public function canViewDeletedPosts()
    {
        if (in_array($this->node_id, \XF::options()->fs_see_deleted_applicable_forums_ids)) {
            return true;
        }

        return parent::canViewDeletedPosts();
    }
}
