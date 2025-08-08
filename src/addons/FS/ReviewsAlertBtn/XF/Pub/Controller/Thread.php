<?php

namespace FS\BanUserChanges\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
    public function assertNotBanned()
    {
        $options = \XF::options();
        $applicableForum = $options->fs_banned_users_applic_forum;
        $visitor = \XF::visitor();

        if (intval($applicableForum) && $visitor->is_banned) {
            $forum = \xf::app()->em()->find('XF:Forum', $applicableForum);

            if (!$forum) {

                parent::assertNotBanned();
            }
        } else {
            parent::assertNotBanned();
        }
    }
}
