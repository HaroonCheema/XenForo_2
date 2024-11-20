<?php

namespace FS\EmbedZoomMeeting\XF\Entity;

use XF\Mvc\Entity\Structure;

use function is_array;

class User extends XFCP_User
{
        public function canViewMeeting(&$error = null)
        {
                $meeting = $this->finder('FS\EmbedZoomMeeting:Meeting')->fetchOne();

                if (!$meeting) {
                        return false;
                }

                return $this->hasPermission('fs_zoom_meeting', 'zoom_meeting_view');
        }
}
