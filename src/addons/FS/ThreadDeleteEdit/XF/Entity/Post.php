<?php

namespace FS\ThreadDeleteEdit\XF\Entity;

use XF\Mvc\Entity\Structure;

class Post extends XFCP_Post
{
    public function canDeletePost()
    {
        $thread = $this->Thread;
        $visitor = \XF::visitor();
        if (!$visitor->user_id || !$thread) {
            return false;
        }

        if (empty($thread->users)) {
            return false;
        }

        $nodeId = $thread->node_id;

        if (!$thread->discussion_open && !$thread->canLockUnlock()) {
            $error = \XF::phraseDeferred('you_may_not_perform_this_action_because_discussion_is_closed');
            return false;
        }

        if ($this->isFirstPost()) {
            return false;
        }

        if ($this->user_id != $visitor->user_id && !($visitor->is_admin && $visitor->is_moderator)) {
            $editLimit = $visitor->hasNodePermission($nodeId, 'editOwnPostTimeLimit');
            if ($editLimit != -1 && (!$editLimit || $this->post_date < \XF::$time - 60 * $editLimit)) {
                $error = \XF::phraseDeferred('message_edit_time_limit_expired', ['minutes' => $editLimit]);
                return false;
            }

            if (!$thread->Forum || !$thread->Forum->allow_posting) {
                $error = \XF::phraseDeferred('you_may_not_perform_this_action_because_forum_does_not_allow_posting');
                return false;
            }

            $user_names = explode(" ", $thread->users);

            $user_name = implode("", $user_names);

            $user_names = explode(",", $user_name);

            if (!in_array($visitor->username, $user_names)) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function canEditPost()
    {
        $thread = $this->Thread;
        $visitor = \XF::visitor();
        if (!$visitor->user_id || !$thread) {
            return false;
        }

        if (empty($thread->users)) {
            return false;
        }

        $nodeId = $thread->node_id;

        if (!$thread->discussion_open && !$thread->canLockUnlock()) {
            $error = \XF::phraseDeferred('you_may_not_perform_this_action_because_discussion_is_closed');
            return false;
        }

        if ($this->user_id != $visitor->user_id && !($visitor->is_admin && $visitor->is_moderator)) {
            $editLimit = $visitor->hasNodePermission($nodeId, 'editOwnPostTimeLimit');
            if ($editLimit != -1 && (!$editLimit || $this->post_date < \XF::$time - 60 * $editLimit)) {
                $error = \XF::phraseDeferred('message_edit_time_limit_expired', ['minutes' => $editLimit]);
                return false;
            }

            if (!$thread->Forum || !$thread->Forum->allow_posting) {
                $error = \XF::phraseDeferred('you_may_not_perform_this_action_because_forum_does_not_allow_posting');
                return false;
            }

            $user_names = explode(" ", $thread->users);

            $user_name = implode("", $user_names);

            $user_names = explode(",", $user_name);

            if (!in_array($visitor->username, $user_names)) {
                return false;
            }

            return true;
        }

        return false;
    }
}
