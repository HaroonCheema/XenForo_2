<?php

namespace FS\AttachmentsQueue\XF\Entity;

use XF\Mvc\Entity\Structure;

class Post extends XFCP_Post
{
    public function getAwaitingApproval()
    {
        $isAnyInModerator = \XF::finder('XF:Attachment')->where('content_type', 'post')->where('content_id', $this->post_id)->where('attachment_state', 'pending')->total();

        $visitor = \XF::visitor();

        if ($isAnyInModerator && $visitor->user_id == $this->user_id) {
            return true;
        }

        return false;
    }
}
