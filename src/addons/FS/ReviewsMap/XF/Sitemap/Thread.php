<?php

namespace FS\ReviewsMap\XF\Sitemap;

class Thread extends XFCP_Thread
{
    public function getThreadRecords($start)
    {
        $app = \XF::app();
        $user = \XF::visitor();
        $options = \XF::options();

        $threadLimits = intval($options->fs_thread_sitemap_limits) + 1;
        $threadOrderBy = $options->fs_thread_sitemap_order_by;

        $startDate = strtotime($options->fs_thread_sitemap_from);
        $endDate = strtotime($options->fs_thread_sitemap_to);

        $totalThreads = \XF::finder('XF:Thread')->where('discussion_state', 'visible');
        // $isDateApplied = false;

        if ($startDate && !$endDate) {
            $totalThreads->where('post_date', '>', $startDate);
            // $isDateApplied = true;
        } elseif ($endDate && !$startDate) {
            $totalThreads->where('post_date', '<', $endDate);
            // $isDateApplied = true;
        } elseif ($startDate && $endDate && ($endDate > $startDate)) {
            $totalThreads->where('post_date', '>', $startDate)->where('post_date', '<', $endDate);
            // $isDateApplied = true;
        }

        $threadIds = $totalThreads->order($threadOrderBy, 'desc')->limit($threadLimits)->pluckfrom('thread_id')->fetch()->toArray();

        if (!$threadIds) {
            return [];
        }

        $lastThreadId = $start;

        if ($start != 0) {

            // if ($isDateApplied) {
            //     $threadIds = array_values($threadIds);
            // }

            if (($pos = array_search($lastThreadId, $threadIds)) !== false) {
                $threadIds = array_slice($threadIds, $pos + 1);
            }
        }

        if (empty($threadIds)) {
            return [];
        }

        $newThreadIds = [];
        if (!empty($threadIds)) {
            foreach ($threadIds as $id) {
                $newThreadIds[$id] = $id;
            }
        }

        // $ids = $this->getIds('xf_thread', 'thread_id', $start, $threadLimits);

        $threadFinder = $app->finder('XF:Thread');

        $threads = $threadFinder
            ->where('thread_id', $threadIds)
            ->with(['Forum', 'Forum.Node', 'Forum.Node.Permissions|' . $user->permission_combination_id])
            ->order($threadOrderBy, 'desc')
            ->fetch();

        return $threads;
    }
}
