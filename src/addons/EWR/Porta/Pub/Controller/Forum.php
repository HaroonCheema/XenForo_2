<?php

namespace EWR\Porta\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum
{
	protected function finalizeThreadCreate(\XF\Service\Thread\Creator $creator)
	{
		$reply = parent::finalizeThreadCreate($creator);
		
		if ($this->filter('article-promote', 'bool') &&
			\XF::visitor()->hasPermission('EWRporta', 'submitArticles'))
		{
			$thread = $creator->getThread();
			throw $this->exception($this->redirect($this->buildLink('threads/article-edit', $thread)));
		}
		
		return $reply;
	}
}