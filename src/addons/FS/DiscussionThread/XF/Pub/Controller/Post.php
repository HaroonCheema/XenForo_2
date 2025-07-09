<?php

namespace FS\DiscussionThread\XF\Pub\Controller;

use XF\Pub\Controller\AbstractController;

use XF\Mvc\ParameterBag;

class Post extends XFCP_Post
{
    public function actionComment(ParameterBag $params)
    {
        $post = $this->assertViewablePost($params->post_id);

        if (!$post->Thread->DiscThread || !$post->Thread->canCommentDiscussion()) {
            return $this->noPermission();
        }

        $discThread = $post->Thread->DiscThread;

        $postLink = $this->buildLink('canonical:posts', $post);

        $message = "[QUOTE]
[B]" . \XF::phrase('fs_discussion_related_post') . "[/B]
[URL='$postLink']" . $postLink . "[/URL][/QUOTE]";

        $draft = $discThread->draft_reply;

        $draft->message = $message;
        $draft->extra_data = [];
        $draft->save();

        $dtUnreadPostLink = \XF::options()->dtUnreadPostLink;

        if ($dtUnreadPostLink)
            return $this->redirect($this->buildLink('threads/unread', $discThread));
        else
            return $this->redirect($this->buildLink('threads', $discThread));
    }
}
