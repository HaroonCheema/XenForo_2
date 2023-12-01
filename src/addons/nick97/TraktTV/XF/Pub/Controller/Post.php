<?php

namespace nick97\TraktTV\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Post extends XFCP_Post
{
	public function actionEdit(ParameterBag $params)
	{
		/** @var \nick97\TraktTV\XF\Entity\Post $post */
		$post = $this->assertViewablePost($params->post_id, ['Thread', 'Thread.TV']);

		$thread = $post->Thread;

		if ($thread->discussion_type === 'snog_tv') {
			if ($post->isFirstPost() && $thread->TV) {
				return $this->rerouteController('nick97\TraktTV:TV', 'edit', ['thread_id' => $thread->thread_id]);
			} elseif ($post->TVPost) {
				return $this->rerouteController('nick97\TraktTV:TVPost', 'edit', ['post_id' => $post->post_id]);
			}
		}

		return parent::actionEdit($params);
	}
}
