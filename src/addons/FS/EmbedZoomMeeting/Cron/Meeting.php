<?php

namespace FS\EmbedZoomMeeting\Cron;

class Meeting
{
    public static function refreshToken()
    {
        $app = \xf::app();

        $service = $app->service('FS\EmbedZoomMeeting:Meeting');

        $service->freshToken();
    }
}
