<?php

namespace ThemeHouse\ThreadCredits\Cron;

class ExpireCredits
{
    public static function run(): void
    {
        \XF::app()->jobManager()->enqueueUnique('thtcExpireCredits', 'ThemeHouse\ThreadCredits:ExpireCredits', [], false);
    }
}