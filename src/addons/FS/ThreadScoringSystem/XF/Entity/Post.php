<?php

namespace FS\ThreadScoringSystem\XF\Entity;

class Post extends XFCP_Post
{
    protected function _postSave()
    {
        $parent = parent::_postSave();

        $thread = $this->Thread;

        $thread->fastUpdate('last_thread_update', \XF::$time);

        return $parent;
    }
}
