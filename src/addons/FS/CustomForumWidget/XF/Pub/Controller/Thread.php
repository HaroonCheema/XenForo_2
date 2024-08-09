<?php

namespace FS\CustomForumWidget\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
    public function actionPost(ParameterBag $params)
    {
        $isClick = $this->filter('isClicked', 'uint');

        if (!empty($isClick)) {
            if ($isClick == 2) {
                $postId = max(0, intval($params->post_id));
                if (!$postId) {
                    return $this->notFound();
                }

                $visitor = \XF::visitor();
                $with = [
                    'Thread',
                    'Thread.Forum',
                    'Thread.Forum.Node',
                    'Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id
                ];

                /** @var \XF\Entity\Post $post */
                $post = $this->em()->find('XF:Post', $postId, $with);
                if (!$post) {
                    $thread = $this->em()->find('XF:Thread', $params->thread_id);
                    if ($thread) {
                        return $this->redirect($this->buildLink('threads', $thread));
                    } else {
                        return $this->notFound();
                    }
                }

                $incCount = $post->Thread['click_count'] + 1;

                $post->Thread->fastUpdate('click_count', $incCount);
            }
        }

        return parent::actionPost($params);
    }
}
