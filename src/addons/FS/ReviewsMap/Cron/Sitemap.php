<?php

namespace FS\ReviewsMap\Cron;

class Sitemap
{
    public static function triggerSitemapRebuild()
    {
        $app = \XF::app();
        if ($app->options()->reviewmapAutoRebuild) {
            $app->jobManager()->enqueueUnique('fsSitemapAuto', 'FS\ReviewsMap:ThreadSitemap', [], false);
        }
    }
}
