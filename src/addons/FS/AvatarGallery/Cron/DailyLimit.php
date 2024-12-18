<?php

namespace FS\AvatarGallery\Cron;

class DailyLimit
{
    public static function midNight()
    {
        \xf::db()->update('xf_user', [
            'random_avatar_limit' => 0
        ], null);
    }
}
