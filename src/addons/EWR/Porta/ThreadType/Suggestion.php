<?php

namespace EWR\Porta\ThreadType;

use XF\Entity\Forum;
use XF\Entity\Post;
use XF\Entity\Thread;
use XF\Http\Request;
use XF\Mvc\Entity\AbstractCollection;
use XF\Pub\Controller\AbstractController;

class Suggestion extends XFCP_Suggestion
{
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
				'ewr_porta_thread_type' => 'thread_view_type_suggestion',
				'pinned_first_post_macro' => 'post_article_macros::article',
				'pinned_first_post_macro_args' => ['isExpanded' => $isExpanded]
			]);
			
			if ($thread->showPortaComments())
			{
				$overrides = array_merge($overrides, [
					'ewr_porta_post_macro' => 'post_suggestion_macros::suggestion',
					'post_macro' => 'EWRporta_article_macros::suggestion',
				]);
			}
		}
		
		return $overrides;
	}
}