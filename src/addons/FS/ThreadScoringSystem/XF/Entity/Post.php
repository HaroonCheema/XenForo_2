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

    // protected function _postDelete()
    // {
    //     $parent = parent::_postDelete();

    //     $thread = $this->Thread;

    //     $postReply = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
    //     $postReply->addEditReplyPoints($thread, $this->post_id);

    //     return $parent;
    // }
}
