<?php

namespace FS\BanUserChanges\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum
{
    public function assertNotBanned()
    {
        $options = \XF::options();
        $applicableForum = $options->fs_banned_users_applic_forum;
        $visitor = \XF::visitor();

        if (intval($applicableForum) && $visitor->is_banned) {
            $forum = $this->assertViewableForum($applicableForum ?: 0);

            if (!$forum) {

                parent::assertNotBanned();
            }
        } else {
            parent::assertNotBanned();
        }
    }
}
