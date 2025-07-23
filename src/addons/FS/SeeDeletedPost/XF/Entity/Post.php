<?php

namespace FS\SeeDeletedPost\XF\Entity;

use XF\Mvc\ParameterBag;

class Post extends XFCP_Post
{

    public function canView(&$error = null)
    {
        if ($this->message_state == 'deleted' && in_array($this->Thread->node_id, \XF::options()->fs_see_deleted_applicable_forums_ids)) {
            return true;
        }

        return parent::canView($error);
    }
}
