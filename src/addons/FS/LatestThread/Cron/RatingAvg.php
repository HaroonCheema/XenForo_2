<?php

namespace FS\LatestThread\Cron;

class RatingAvg
{
    public static function updateRatingAvg()
    {
        $nodeIds = \XF::Options()->fs_filter_node;

        $finder = \XF::finder('XF:Thread');

        if ($nodeIds) {
            $finder->where('node_id', $nodeIds);
        }

        $allThreads = $finder->fetch();

        if (count($allThreads)) {

            foreach ($allThreads as $thread) {
                $thread->fastUpdate('latest_rating_avg', $thread->brivium_rating_avg);
            }
        }
    }
}
