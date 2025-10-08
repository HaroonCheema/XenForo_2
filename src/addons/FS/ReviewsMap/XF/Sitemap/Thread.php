<?php

namespace FS\ReviewsMap\XF\Sitemap;

class Thread extends XFCP_Thread
{
    public function getThreadRecords($start)
    {
        $app = $this->app;
        $user = \XF::visitor();
        $options = \XF::options();

        $threadLimits = intval($options->fs_thread_sitemap_limits) + 1;
        $threadOrderBy = $options->fs_thread_sitemap_order_by;

        $totalThreads = $app->finder('XF:Thread')->where('discussion_state', 'visible')->order($threadOrderBy, 'desc')->limitByPage(1, $threadLimits);

        $threadIds = $totalThreads->pluckfrom('thread_id')->fetch()->toArray();

        $lastThreadId = $start;

        if (($pos = array_search($lastThreadId, $threadIds)) !== false && $start != 0) {
            $threadIds = array_slice($threadIds, $pos + 1);
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
