<?php

namespace ThemeHouse\Monetize\Cron;

/**
 * Class CleanUp
 * @package ThemeHouse\Monetize\Cron
 */
class CleanUp
{
    /**
     * Clean up tasks that should be done daily. This task cannot be relied on
     * to run daily, consistently.
     * @throws \XF\Db\Exception
     * @throws \XF\Db\Exception
     * @throws \XF\Db\Exception
     */
    public static function runDailyCleanUp()
    {
        \XF::db()->beginTransaction();
        /** @var \ThemeHouse\Monetize\Repository\CommunicationLog $logRepo */
        $logRepo = \XF::repository('ThemeHouse\Monetize:CommunicationLog');
        $logRepo->pruneLogs('alert');
        $logRepo->pruneLogs('email');
        $logRepo->pruneLogs('message');
        \XF::db()->commit();
    }
}
