<?php

namespace FS\TractorByNetMyThreads\XF\Finder;

class Thread extends XFCP_Thread
{
    public function inForum(\XF\Entity\Forum $forum, array $limits = [])
    {
        $visitor = \XF::visitor();

        if (!$visitor->canUseMyThreads()) {
            return parent::inForum($forum, $limits);
        }

        $urI = \xf::app()->request()->getRequestUri();
        // $urI = "https://www.tractorbynet.com/forums/my-ads";
        // $urI = "https://www.tractorbynet.com/forums/my-ads/?thread_fields[Type][0]=Tractor";

        $parts = parse_url($urI);
        $route = '';

        if (!empty($parts['path'])) {
            $pathParts = explode('/', trim($parts['path'], '/'));
            $route = end($pathParts);
        } elseif (!empty($parts['query'])) {
            $route = trim($parts['query'], '/');
        } else {
            $route = '';
        }

        $options = \XF::options();
        $nodeId = $forum->node_id;

        if ($route == "my-ads" && ($nodeId == intval($options->fs_tbn_my_thread_forum_id) || $nodeId == intval($options->fs_tbn_my_threads_specific_forum_id))) {
            $this->where('user_id', $visitor->user_id);
        } else {
            return parent::inForum($forum, $limits);
        }

        $limits = array_replace([
            'visibility' => true,
            'allowOwnPending' => false
        ], $limits);

        $this->where('node_id', $forum->node_id);

        $this->applyForumDefaultOrder($forum);

        if ($limits['visibility']) {
            $this->applyVisibilityChecksInForum($forum, $limits['allowOwnPending']);
        }

        return $this;
    }
}
