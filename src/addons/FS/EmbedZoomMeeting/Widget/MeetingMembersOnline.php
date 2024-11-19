<?php

namespace FS\EmbedZoomMeeting\Widget;

use XF\Widget\AbstractWidget;

class MeetingMembersOnline extends AbstractWidget
{
    public function render()
    {
        $onlineUsers = \XF::finder('FS\EmbedZoomMeeting:Register')->where('status', 1)->fetch();
        $guests = \XF::finder('FS\EmbedZoomMeeting:Register')->where('status', 1)->where('user_id', 0)->total();

        $total = count($onlineUsers);

        $viewParams = [
            'online' => $total ? $onlineUsers : [],
            'total' => $total,
            'members' => $total - $guests,
            'guests' => $guests
        ];

        return $this->renderer('fs_zoom_meetings_members_online', $viewParams);
    }

    public function getOptionsTemplate()
    {
        return null;
    }
}
