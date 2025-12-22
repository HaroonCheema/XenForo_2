<?php

namespace EWR\Porta\Pub\Controller;

use XF\Mvc\ParameterBag;

class Category extends \XF\Pub\Controller\AbstractController
{
	public function actionIndex(ParameterBag $params)
	{
		$category = $this->assertCategoryExists($params->category_id);
		$articleRepo = $this->getArticleRepo();
		
		$page = max(1, $params->page);
		$perPage = $this->options()->EWRporta_articles_perpage;
		$entries = $articleRepo->findArticle()->limitByPage($page, $perPage)
			->with('CatLink', true)
			->where('CatLink.category_id', $category->category_id)
			->where('Thread.discussion_state', 'visible')
			->where('article_date', '<', \XF::$time);

		if ($this->responseType == 'rss')
		{
			return $this->view('EWR\Porta:Article', '', ['category' => $category, 'articles' => $entries->fetch()]);
		}
		
		$total = $entries->total();
		$maxPage = ceil($total / $perPage);
		
		$this->assertCanonicalUrl($this->buildLink('ewr-porta/categories', $category, ['page' => $page]));
		$this->assertValidPage($page, $perPage, $total, 'ewr-porta/categories', $category);
		
		if ($category->style_id)
		{
			$this->setViewOption('style_id', $category->style_id);
		}
		
		$viewParams = $articleRepo->prepareViewParams($entries->fetch()) + [
			'category' => $category,
			'total' => $total,
			'page' => $page,
			'perPage' => $perPage
		];
		
		return $this->view('EWR\Porta:Articles\List', 'EWRporta_articles_category', $viewParams);
	}
	
	protected function assertCategoryExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('EWR\Porta:Category', $id, $with, $phraseKey);
	}
	
	protected function getArticleRepo()
	{
		return $this->repository('EWR\Porta:Article');
	}
	
	protected function getCategoryRepo()
	{
		return $this->repository('EWR\Porta:Category');
	}

	public static function getActivityDetails(array $activities)
	{
		return self::getActivityDetailsForContent(
			$activities,
			\XF::phrase('EWRporta_viewing_article_category'),
			'category_id',
			function(array $ids)
			{
				$categories = \XF::em()->findByIds(
					'EWR\Porta:Category',
					$ids
				);

				$router = \XF::app()->router('public');
				$data = [];

				foreach ($categories AS $id => $category)
				{
					$data[$id] = [
						'title' => $category->category_name,
						'url' => $router->buildLink('ewr-porta/categories', $category)
					];
				}

				return $data;
			}
		);
	}
}