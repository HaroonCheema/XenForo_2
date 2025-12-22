<?php

namespace EWR\Porta\Pub\Controller;

use XF\Mvc\ParameterBag;

class Author extends \XF\Pub\Controller\AbstractController
{
	public function actionIndex(ParameterBag $params)
	{
		if ($params->user_id)
		{
			return $this->rerouteController(__CLASS__, 'author', $params);
		}
		
		$authorRepo = $this->getAuthorRepo();
		$entries = $authorRepo->findAuthor();
		
		$viewParams = [
			'authors' => $entries->fetch(),
		];
		
		return $this->view('EWR\Porta:Authors\List', 'EWRporta_authors', $viewParams);
	}
	
	public function actionAuthor(ParameterBag $params)
	{
		$author = $this->em()->find('EWR\Porta:Author', $params->user_id);
		if (!$author)
		{
			return $this->redirect($this->buildLink('members', ['user_id' => $params->user_id]));
		}
		
		$articleRepo = $this->getArticleRepo();
		
		$page = max(1, $params->page);
		$perPage = $this->options()->EWRporta_articles_perpage;
		$entries = $articleRepo->findArticle()->limitByPage($page, $perPage)
			->where('Thread.user_id', $author->user_id)
			->where('Thread.discussion_state', 'visible')
			->where('article_date', '<', \XF::$time);

		if ($this->responseType == 'rss')
		{
			return $this->view('EWR\Porta:Article', '', ['author' => $author, 'articles' => $entries->fetch()]);
		}
		
		$total = $entries->total();
		$maxPage = ceil($total / $perPage);
		
		$this->assertCanonicalUrl($this->buildLink('ewr-porta/authors', $author->User, ['page' => $page]));
		$this->assertValidPage($page, $perPage, $total, 'ewr-porta/authors', $author->User);
		
		$viewParams = $articleRepo->prepareViewParams($entries->fetch()) + [
			'author' => $author,
			'total' => $total,
			'page' => $page,
			'perPage' => $perPage
		];
		
		return $this->view('EWR\Porta:Articles\List', 'EWRporta_articles_author', $viewParams);
	}
	
	public function actionEdit(ParameterBag $params)
	{
		$author = $this->assertAuthorExists($params->user_id);
		
		if (!$author->canEdit())
		{
			return $this->noPermission();
		}
		
		if ($this->isPost())
		{
			if ($upload = $this->request->getFile('upload', false, false))
			{
				$this->getAuthorRepo()->setAuthorFromUpload($author, $upload);
			}
			
			$input = $this->filter('author', 'array');
			$input['author_byline'] = $this->plugin('XF:Editor')->fromInput('byline');
			
			$form = $this->formAction();
			$form->basicEntitySave($author, $input);
			$form->run();
			
			return $this->redirect($this->buildLink('ewr-porta/authors'));
		}
		
		$viewParams = [
			'author' => $author,
		];
		
		return $this->view('EWR\Porta:Author\Edit', 'EWRporta_author_edit', $viewParams);
	}
	
	protected function assertAuthorExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('EWR\Porta:Author', $id, $with, $phraseKey);
	}
	
	protected function getArticleRepo()
	{
		return $this->repository('EWR\Porta:Article');
	}
	
	protected function getAuthorRepo()
	{
		return $this->repository('EWR\Porta:Author');
	}

	public static function getActivityDetails(array $activities)
	{
		return self::getActivityDetailsForContent(
			$activities,
			\XF::phrase('EWRporta_viewing_article_author'),
			'user_id',
			function(array $ids)
			{
				$authors = \XF::em()->findByIds(
					'EWR\Porta:Author',
					$ids,
					['User']
				);

				$router = \XF::app()->router('public');
				$data = [];

				foreach ($authors AS $id => $author)
				{
					$data[$id] = [
						'title' => $author->author_name,
						'url' => $router->buildLink('ewr-porta/authors', $author->User)
					];
				}

				return $data;
			}
		);
	}
}