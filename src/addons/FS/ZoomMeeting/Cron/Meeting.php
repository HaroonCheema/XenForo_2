<?php

namespace FS\ZoomMeeting\Cron;

class Meeting
{
    public static function refreshToken()
    {
        $app = \xf::app();

        $service = $app->service('FS\ZoomMeeting:Meeting');

        $service->freshToken();
    }
    
    public static function alertRegisters()
    {
        $app = \xf::app();

        $service = $app->service('FS\ZoomMeeting:Meeting');

        $service->alertRegisterUsers();
    }
}
