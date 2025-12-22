<?php

namespace EWR\Porta\ThreadType;

use XF\Entity\Forum;
use XF\Entity\Post;
use XF\Entity\Thread;
use XF\Http\Request;
use XF\Mvc\Entity\AbstractCollection;
use XF\Pub\Controller\AbstractController;

class Poll extends XFCP_Poll
{
	public function isFirstPostPinned(Thread $thread): bool
	{
		if ($thread->isPortaArticle())
		{
			return true;
		}
		
		return parent::isFirstPostPinned($thread);
	}
	
	public function getThreadViewAndTemplate(Thread $thread): array
	{
		if ($thread->isPortaArticle())
		{
			return ['EWR\Porta:ThreadView', 'EWRporta_article_thread_view'];
		}
		
		return parent::getThreadViewAndTemplate($thread);
	}
	
	public function getThreadViewTemplateOverrides(Thread $thread, array $extra = []): array
	{
		$overrides = parent::getThreadViewTemplateOverrides($thread, $extra);
		
		if ($thread->isPortaArticle())
		{
			$isExpanded = isset($extra['page'])
				? ($extra['page'] == 1)
				: true;

			$overrides = array_merge($overrides, [
				'ewr_porta_thread_type' => 'thread_view_type_poll',
				'pinned_first_post_macro' => 'post_article_macros::article',
				'pinned_first_post_macro_args' => ['isExpanded' => $isExpanded]
			]);
			
			if ($thread->showPortaComments())
			{
				$overrides = array_merge($overrides, [
					'ewr_porta_post_macro' => 'post_macros::post',
					'post_macro' => 'EWRporta_article_macros::post',
				]);
			}
		}
		
		return $overrides;
	}
}