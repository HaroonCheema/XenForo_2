<?php

namespace EWR\Porta\Pub\Controller;

use XF\Mvc\ParameterBag;

class Post extends XFCP_Post
{
	public function actionShow(ParameterBag $params)
	{
		$reply = parent::actionShow($params);
		
		if (!$reply instanceof \XF\Mvc\Reply\View)
		{
			return $reply;
		}
		
		$post = $reply->getParam('post');
		$thread = $reply->getParam('thread');
		$article = $thread->PortaArticle;
		
		if (!empty($article->article_format) && $this->options()->EWRporta_article_format['article'])
		{
			if ($post->isFirstPost())
			{
				$reply->setParam('articlePost', true);
			}
			elseif ($this->options()->EWRporta_article_format['comments'])
			{
				$reply->setParam('articleComment', true);
			}
		}
		
		return $reply;
	}
	
	public function actionEdit(ParameterBag $params)
	{
		$reply = parent::actionEdit($params);
		
		if (!$reply instanceof \XF\Mvc\Reply\View)
		{
			return $reply;
		}
		
		if ($this->isPost())
		{
			$post = $reply->getParam('post');
			$thread = $reply->getParam('thread');
			$article = $thread->PortaArticle;
			
			if (!empty($article->article_format) && $this->options()->EWRporta_article_format['article'])
			{
				if ($post->isFirstPost())
				{
					$reply->setParam('articlePost', true);
				}
				elseif ($this->options()->EWRporta_article_format['comments'])
				{
					$reply->setParam('articleComment', true);
				}
			}
		}
		
		return $reply;
	}
}