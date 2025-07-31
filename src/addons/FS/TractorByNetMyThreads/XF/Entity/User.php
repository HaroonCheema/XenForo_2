<?php

namespace FS\TractorByNetMyThreads\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public function canUseMyThreads()
    {
        $options = \XF::options();

        if (!$options->fs_tbn_my_threads_specific_forum_id || !$options->fs_tbn_my_thread_forum_id || !\XF::visitor()->user_id) {
            return false;
        }

        $specificForumThreadsCount = \XF::finder("XF:Thread")->where('node_id', $options->fs_tbn_my_threads_specific_forum_id)->where('user_id', \XF::visitor()->user_id)->total();

        if (!$specificForumThreadsCount) {
            return false;
        }

        if ($specificForumThreadsCount < $options->fs_tbn_my_thread_minimum_items) {
            return false;
        }

        return true;
    }
}
