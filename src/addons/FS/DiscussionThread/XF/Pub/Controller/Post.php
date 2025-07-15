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

        // $postLink = $this->buildLink('posts', $post);

        $baseUrl = \XF::options()->boardUrl;

        $postLink = $baseUrl . "/index.php?posts/" . $post->post_id . "/";

        // $customUrlSite = "https://celebforum.to";

        // $postLink = $customUrlSite . "/index.php?posts/" . $post->post_id . "/";

        $quoteMessage = $post->message;

        $visitor = \XF::visitor();

        $mediaTags = $this->Finder('FS\MediaTagSetting:MediaTag')->order('id', 'Desc')->fetch();

        $userGroupFinder =  \XF::finder('XF:UserGroup')->order('user_group_id', 'Asc');

        $userGroupIds = $userGroupFinder->fetchColumns('user_group_id');

        $userIds = array();
        foreach ($userGroupIds as $value) {
            array_push($userIds, strval($value['user_group_id']));
        }

        foreach ($mediaTags as $mediaTag) {

            $unselected = array_diff($userIds, $mediaTag->user_group_ids);

            if ($visitor->isMemberOf($unselected)) {
            } else
            if ($visitor->isMemberOf($mediaTag->user_group_ids)) {
                $quoteMessage = $this->replaceMediaTags($quoteMessage, $mediaTag);
            }
        }

        $message = "[QUOTE]
        [B][URL='$postLink']" . \XF::phrase('fs_discussion_related_post') . "[/URL][/B]
        " . $quoteMessage . "[/QUOTE]";

        $draft = $discThread->draft_reply;

        $draft->message = $message;
        $draft->extra_data = [];
        $draft->save();

        $dtUnreadPostLink = \XF::options()->dtUnreadPostLink;

        if ($dtUnreadPostLink)
            return $this->redirect($this->buildLink('threads/#quickReplyForm', $discThread));
        // return $this->redirect($this->buildLink('threads/unread', $discThread));
        else
            return $this->redirect($this->buildLink('threads/#quickReplyForm', $discThread));
    }

    public function actionEdit(ParameterBag $params)
    {
        $parent = parent::actionEdit($params);

        $post = $this->assertViewablePost($params->post_id, ['Thread.Prefix']);

        $message = $post->message;

        $postLinkText =  \XF::phrase('fs_discussion_related_post');

        $pattern = '/^\[QUOTE\](.*?)\[URL=\'[^\']*?posts\/(\d+)\/\'\]' . $postLinkText . '\[\/URL\](.*?)\[\/QUOTE\]/is';

        if (!preg_match($pattern, $message, $matches)) {

            return $parent;
        }

        if (!$post->canEdit($error)) {
            return $this->noPermission($error);
        }

        if ($this->isPost()) {
            $postLinkText =  \XF::phrase('fs_discussion_related_post');

            $pattern = '/^\[QUOTE\](.*?)\[URL=\'[^\']*?posts\/(\d+)\/\'\]' . $postLinkText . '\[\/URL\](.*?)\[\/QUOTE\]/is';

            if (preg_match($pattern, $message, $matches)) {
                $postId = $matches[2];

                /** @var \XF\Entity\Post $post */
                $quotePost = $this->em()->find('XF:Post', $postId);

                if ($quotePost) {

                    $baseUrl = \XF::options()->boardUrl;

                    $postLink = $baseUrl . "/index.php?posts/" . $quotePost->post_id . "/";

                    // $postLink = $this->buildLink('canonical:posts', $quotePost);

                    $quoteMessage = $quotePost->message;

                    $replaceQuote = "[QUOTE]
		[B][URL='$postLink']" . \XF::phrase('fs_discussion_related_post') . "[/URL][/B]
		" . $quoteMessage . "[/QUOTE]";

                    $message = preg_replace($pattern, $replaceQuote, $message);

                    $post->bulkSet([
                        'message' => $message
                    ]);
                    $post->save();
                }
            }

            return $parent;
        } else {
            $parent = parent::actionEdit($params);

            $quotePost = $post;

            $visitor = \XF::visitor();

            $mediaTags = $this->Finder('FS\MediaTagSetting:MediaTag')->order('id', 'Desc')->fetch();

            $userGroupFinder =  \XF::finder('XF:UserGroup')->order('user_group_id', 'Asc');

            $userGroupIds = $userGroupFinder->fetchColumns('user_group_id');

            $userIds = array();
            foreach ($userGroupIds as $value) {
                array_push($userIds, strval($value['user_group_id']));
            }

            foreach ($mediaTags as $mediaTag) {

                $unselected = array_diff($userIds, $mediaTag->user_group_ids);

                if ($visitor->isMemberOf($unselected)) {
                } else
                if ($visitor->isMemberOf($mediaTag->user_group_ids)) {
                    $quotePost->message = $this->replaceMediaTags($quotePost->message, $mediaTag);
                }
            }

            $parent->setParams([
                // 'post' => $quotePost,
                'removeAjax' => true,
            ]);

            return $parent;
        }
    }

    public function replaceMediaTags($message, \FS\MediaTagSetting\Entity\MediaTag $mediaTag)
    {
        foreach ($mediaTag->media_site_ids as $mediaId) {
            $pattern = '#\[MEDIA=' . preg_quote($mediaId, '#') . '\](.*?)\[/MEDIA\]#i';

            $message = preg_replace_callback($pattern, function ($matches) use ($mediaId) {
                return "[MEDIA={$mediaId}]********[/MEDIA]";
            }, $message);
        }

        return $message;
    }
}
