<?php

namespace FS\UsergroupUsersCount\Cron;

class UsersCountCron
{
    public static function countUsers()
    {
        $updateCounts = \xf::app()->service('FS\UsergroupUsersCount:UsersCount');
        $updateCounts->countAllUsers();
    }
}
