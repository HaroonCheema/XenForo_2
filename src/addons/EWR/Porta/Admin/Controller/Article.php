<?php

namespace EWR\Porta\Admin\Controller;

use XF\Mvc\ParameterBag;

class Article extends \XF\Admin\Controller\AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('EWRporta');
	}
	
	public function actionIndex(ParameterBag $params)
	{
		$page = $this->filterPage();
		$perPage = 100;
		
		$articleRepo = $this->getArticleRepo();
		
		$entries = $articleRepo->findArticle();
		$entries->limitByPage($page, $perPage);

		$filter = $this->filter('_xfFilter', [
			'text' => 'str',
			'prefix' => 'bool'
		]);
		if (strlen($filter['text']))
		{
			$entries->searchTitle($filter['text'], $filter['prefix']);
		}
		
		$viewParams = [
			'articles' => $entries->fetch(),
			'total' => $entries->total(),
			'page' => $page,
			'perPage' => $perPage,
			'filter' => $filter['text'],
		];
		return $this->view('EWR\Porta:Article\List', 'EWRporta_article_list', $viewParams);
	}
	
	public function actionEdit(ParameterBag $params)
	{
		$thread = $this->assertThreadExists($params->thread_id);
		$article = $this->assertArticleExists($params->thread_id);
		
		$categories = $this->getCategoryRepo()->findCategory()
			->with('CatLink', true)
			->where('CatLink.thread_id', $thread->thread_id)
			->fetch();
		$nonCategories = $this->getCategoryRepo()->findCategory()
			->where('category_id', '<>', array_keys($categories->toArray()))
			->fetch();
		
		$attachData = $this->repository('XF:Attachment')->getEditorData('post', $thread->FirstPost);
		$images = $this->getArticleRepo()->getArticleImages($thread);
			
		$viewParams = [
			'thread' => $thread,
			'article' => $article,
			'attachData' => $attachData,
			'images' => $images,
			'categories' => $categories,
			'nonCategories' => $nonCategories,
		];
		
		return $this->view('EWR\Porta:Article\Edit', 'EWRporta_article_edit', $viewParams);
	}
	
	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();
		
		$article = $this->assertArticleExists($params->thread_id, 'Thread');
	
		$input = $this->filter('article', 'array');
		$input['article_format'] = !empty($input['article_format']) ? 1 : 0;
		$input['article_sticky'] = !empty($input['article_sticky']) ? 1 : 0;
		$input['article_exclude'] = !empty($input['article_exclude']) ? 1 : 0;
		$input['article_title'] = !empty($input['article_title']) ? $input['article_title'] : '';
		$input['article_excerpt'] = !empty($input['article_excerpt']) ? $input['article_excerpt'] : '';
		
		$date = $this->filter('date', 'datetime');
		$time = $this->filter('time', 'str');
		list ($hour, $min) = explode(':', $time);
		
		$dateTime = new \DateTime('@'.$date);
		$dateTime->setTimeZone(\XF::language()->getTimeZone());
		$dateTime->setTime($hour, $min);
		$input['article_date'] = $dateTime->getTimestamp();
		
		$form = $this->formAction();
		$form->basicEntitySave($article, $input);
		$form->run();
		
		$this->getCatLinkRepo()->updateCatlinksByThreadId($article->thread_id, $this->filter('catlinks', 'array'));
			
		return $this->redirect($this->buildLink('ewr-porta/articles'));
	}
	
	public function actionDelete(ParameterBag $params)
	{
		$article = $this->assertArticleExists($params->thread_id, 'Thread');

		$plugin = $this->plugin('XF:Delete');
		return $plugin->actionDelete(
			$article,
			$this->buildLink('ewr-porta/articles/delete', $article),
			$this->buildLink('ewr-porta/articles/edit', $article),
			$this->buildLink('ewr-porta/articles'),
			$article->Thread->title
		);
	}
	
	protected function assertArticleExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('EWR\Porta:Article', $id, $with, $phraseKey);
	}
	
	protected function assertThreadExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('XF:Thread', $id, $with, $phraseKey);
	}
	
	protected function getArticleRepo()
	{
		return $this->repository('EWR\Porta:Article');
	}
	
	protected function getCategoryRepo()
	{
		return $this->repository('EWR\Porta:Category');
	}
	
	protected function getCatLinkRepo()
	{
		return $this->repository('EWR\Porta:CatLink');
	}
}