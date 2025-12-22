<?php

namespace EWR\Porta\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
	public function actionIndex(ParameterBag $params)
	{
		$reply = parent::actionIndex($params);
		
		if (!$reply instanceof \XF\Mvc\Reply\View)
		{
			return $reply;
		}
		
		$thread = $reply->getParam('thread');
		
		if ($thread)
		{
			$article = $thread->PortaArticle;
		
			if (!empty($article) && $thread->isPortaArticle())
			{
				$reply->setParam('article', $this->getArticleRepo()->parseArticle($article));
				$reply->setParam('feature', $this->repository('EWR\Porta:Feature')->fetchFeatureByThread($thread));
				$reply->setParam('categories', $this->repository('EWR\Porta:Category')->findCategory()
					->with('CatLink', true)
					->where('CatLink.thread_id', $thread->thread_id)
					->fetch());
			}
		}
		
		return $reply;
	}
	
	public function actionArticleEdit(ParameterBag $params)
	{
		if (!\XF::visitor()->hasPermission('EWRporta', 'submitArticles'))
		{
			return $this->noPermission();
		}
		
		$thread = $this->assertViewableThread($params->thread_id);
		$article = $thread->PortaArticle;
		
		if ($article && !$article->canEdit())
		{
			return $this->noPermission();
		}
		
		if ($this->isPost())
		{
			if (!$article)
			{
				$article = $this->em()->create('EWR\Porta:Article');
			}
			
			$input = $this->filter('article', 'array');
			$input['thread_id'] = $thread->thread_id;
			$input['article_format'] = !empty($input['article_format']) ? 1 : 0;
			$input['article_sticky'] = !empty($input['article_sticky']) ? 1 : 0;
			$input['article_exclude'] = !empty($input['article_exclude']) ? 1 : 0;
			$input['article_title'] = !empty($input['article_title']) ? $input['article_title'] : '';
			$input['article_excerpt'] = !empty($input['article_excerpt']) ? $input['article_excerpt'] : '';
			
			$date = $this->filter('date', 'datetime');
			$time = $this->filter('time', 'str');
			list($hour, $min) = explode(':', $time);
			
			$dateTime = new \DateTime('@'.$date);
			$dateTime->setTimeZone(\XF::language()->getTimeZone());
			$dateTime->setTime($hour, $min);
			$input['article_date'] = $dateTime->getTimestamp();
			
			$form = $this->formAction();
			$form->basicEntitySave($article, $input);
			$form->run();
			
			$this->repository('EWR\Porta:CatLink')->updateCatlinksByThreadId($thread->thread_id, $this->filter('catlinks', 'array'));
			
			return $this->redirect($this->buildLink('threads', $thread));
		}
		
		$categoryRepo = $this->repository('EWR\Porta:Category');
		
		if ($article)
		{
			$categories = $categoryRepo->findCategory()
				->with('CatLink', true)
				->where('CatLink.thread_id', $thread->thread_id)
				->fetch();
			$nonCategories = $categoryRepo->findCategory()
				->where('category_id', '<>', array_keys($categories->toArray()))
				->fetch();
		}
		else
		{
			$categories = array();
			$nonCategories = $categoryRepo->findCategory()->fetch();
		}
		
		$attachData = $this->repository('XF:Attachment')->getEditorData('post', $thread->FirstPost);
		$images = $this->repository('EWR\Porta:Article')->getArticleImages($thread);
		$medios = $this->repository('EWR\Porta:Article')->getArticleMedios($thread);
		
		$viewParams = [
			'thread' => $thread,
			'article' => $article,
			'images' => $images,
			'medios' => $medios,
			'attachData' => $attachData,
			'categories' => $categories,
			'nonCategories' => $nonCategories,
		];
		
		return $this->view('EWR\Porta:Thread\ArticleEdit', 'EWRporta_article_edit', $viewParams);
	}
	
	public function actionArticleDelete(ParameterBag $params)
	{
		$article = $this->assertArticleExists($params->thread_id, 'Thread');
		
		if (!$article->canEdit())
		{
			return $this->noPermission();
		}
		
		if (!$article->preDelete())
		{
			return $this->error($article->getErrors());
		}

		if ($this->isPost())
		{
			$article->delete();
			return $this->redirect($this->buildLink('threads', $article));
		}
		else
		{
			$viewParams = [
				'article' => $article
			];
			return $this->view('EWR\Portal:Article\Delete', 'EWRporta_article_delete', $viewParams);
		}
	}
	
	public function actionFeatureEdit(ParameterBag $params)
	{
		if (!\XF::visitor()->hasPermission('EWRporta', 'submitFeatures'))
		{
			return $this->noPermission();
		}
		
		$thread = $this->assertViewableThread($params->thread_id);
		$feature = $thread->PortaFeature;
		
		if ($feature && !$feature->canEdit())
		{
			return $this->noPermission();
		}
		
		if ($this->isPost())
		{
			if (!$feature)
			{
				$feature = $this->em()->create('EWR\Porta:Feature');
			}
			
			if ($upload = $this->request->getFile('upload', false, false))
			{
				$this->repository('EWR\Porta:Feature')->setFeatureFromUpload($thread, $upload);
			}
			
			$input = $this->filter('feature', 'array');
			$input['thread_id'] = $thread->thread_id;
			$input['feature_title'] = !empty($input['feature_title']) ? $input['feature_title'] : '';
			$input['feature_excerpt'] = !empty($input['feature_excerpt']) ? $input['feature_excerpt'] : '';
			
			$date = $this->filter('date', 'datetime');
			$time = $this->filter('time', 'str');
			list ($hour, $min) = explode(':', $time);
			
			$dateTime = new \DateTime('@'.$date);
			$dateTime->setTimeZone(\XF::language()->getTimeZone());
			$dateTime->setTime($hour, $min);
			$input['feature_date'] = $dateTime->getTimestamp();
			
			$form = $this->formAction();
			$form->basicEntitySave($feature, $input);
			$form->run();
			
			return $this->redirect($this->buildLink('threads', $thread));
		}
		
		$viewParams = [
			'thread' => $thread,
			'feature' => $feature,
		];
		
		return $this->view('EWR\Porta:Thread\FeatureEdit', 'EWRporta_feature_edit', $viewParams);
	}
	
	public function actionFeatureDelete(ParameterBag $params)
	{
		$feature = $this->assertFeatureExists($params->thread_id, 'Thread');
		
		if (!$feature->canEdit())
		{
			return $this->noPermission();
		}
		
		if (!$feature->preDelete())
		{
			return $this->error($feature->getErrors());
		}

		if ($this->isPost())
		{
			$feature->delete();
			return $this->redirect($this->buildLink('threads', $feature));
		}
		else
		{
			$viewParams = [
				'feature' => $feature
			];
			return $this->view('EWR\Portal:Feature\Delete', 'EWRporta_feature_delete', $viewParams);
		}
	}
	
	protected function assertArticleExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('EWR\Porta:Article', $id, $with, $phraseKey);
	}
	
	protected function assertFeatureExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('EWR\Porta:Feature', $id, $with, $phraseKey);
	}
	
	protected function getArticleRepo()
	{
		return $this->repository('EWR\Porta:Article');
	}
}