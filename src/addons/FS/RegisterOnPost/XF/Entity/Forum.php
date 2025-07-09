<?php

namespace FS\RegisterOnPost\XF\Entity;

use XF\Mvc\Entity\Structure;

class Forum extends XFCP_Forum
{
    public function canRegisterUsingPost()
    {
        $options = \XF::options();

        if (in_array($this->node_id, $options->fs_register_on_post_forums) && !\XF::visitor()->user_id) {
            return true;
        }

        return false;
    }
}
