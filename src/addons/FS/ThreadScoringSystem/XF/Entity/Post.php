<?php

namespace FS\ThreadScoringSystem\XF\Entity;

class Post extends XFCP_Post
{
    // protected function _postSave()
    // {
    //     $parent = parent::_postSave();

    //     $thread = $this->Thread;

    //     $postReply = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
    //     $postReply->addEditReplyPoints($thread);

    //     $threadQuestion = $this->Thread->Question;

    //     if ($threadQuestion && $threadQuestion->solution_post_id) {

    //         $threadQuestionServ = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
    //         $threadQuestionServ->addEditSolutionPoints($threadQuestion);
    //     }

    //     return $parent;
    // }

    // protected function _postDelete()
    // {
    //     $parent = parent::_postDelete();

    //     $thread = $this->Thread;

    //     $postReply = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
    //     $postReply->addEditReplyPoints($thread, $this->post_id);

    //     return $parent;
    // }
}
