<?php

namespace EWR\Porta\Pub\Controller;

use XF\Mvc\ParameterBag;

class Article extends \XF\Pub\Controller\AbstractController
{
	public function actionIndex(ParameterBag $params)
	{
		if ($params->thread_id)
		{
			return $this->rerouteController(__CLASS__, 'article', $params);
		}
		
		$articleRepo = $this->getArticleRepo();
		
		$page = max(1, $params->page);
		$perPage = $this->options()->EWRporta_articles_perpage;
		$entries = $articleRepo->findArticle()->limitByPage($page, $perPage)
			->where('Thread.discussion_state', 'visible')
			->where('article_date', '<', \XF::$time)
			->where('article_exclude', '0');

		if ($this->responseType == 'rss')
		{
			return $this->view('EWR\Porta:Article', '', ['articles' => $entries->fetch()]);
		}
		
		$total = $entries->total();
		$maxPage = ceil($total / $perPage);
		
		$this->assertCanonicalUrl($this->buildLink('ewr-porta', '', ['page' => $page]));
		$this->assertValidPage($page, $perPage, $total, 'ewr-porta');
		
		$viewParams = $articleRepo->prepareViewParams($entries->fetch()) + [
			'total' => $total,
			'page' => $page,
			'perPage' => $perPage
		];
		
		return $this->view('EWR\Porta:Articles\List', 'EWRporta_articles_index', $viewParams);
	}
	
	public function actionArticle(ParameterBag $params)
	{
		return $this->rerouteController('XF:Thread', 'index', $params);
	}
	
	protected function getArticleRepo()
	{
		return $this->repository('EWR\Porta:Article');
	}

	public static function getActivityDetails(array $activities)
	{
		return \XF::phrase('EWRporta_viewing_the_article_index');
	}
}
