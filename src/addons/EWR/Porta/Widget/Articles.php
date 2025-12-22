<?php

namespace EWR\Porta\Widget;

class Articles extends \XF\Widget\AbstractWidget
{
	protected $defaultOptions = [
		'limit' => 5,
		'category' => 0,
		'author' => 0,
		'masonry' => false,
	];

	protected function getDefaultTemplateParams($context)
	{
		$params = parent::getDefaultTemplateParams($context);
		if ($context == 'options')
		{
			$categoryRepo = $this->app->repository('EWR\Porta:Category');
			$params['categories'] = $categoryRepo->findCategory()->fetch();
			
			$authorRepo = $this->app->repository('EWR\Porta:Author');
			$params['authors'] = $authorRepo->findAuthor()->fetch();
		}
		return $params;
	}
	
	public function render()
	{
		$options = $this->options;
		$articleRepo = $this->app->repository('EWR\Porta:Article');
		$entries = $articleRepo->findArticle()->limit($options['limit'])
			->where('Thread.discussion_state', 'visible')
			->where('article_date', '<', \XF::$time);
		
		if ($options['category'])
		{
			$entries->with('CatLink')
				->where('CatLink.category_id', $options['category']);
		}
		
		if ($options['author'])
		{
			$entries->with('Thread')
				->where('Thread.user_id', $options['author']);
		}
		
		if (!$articles = $entries->fetch())
		{
			return false;
		}
		
		$viewParams = $articleRepo->prepareViewParams($articles);
		
		return $this->renderer('widget_EWRporta_articles', $viewParams);
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'limit' => 'uint',
			'category' => 'uint',
			'author' => 'uint',
			'masonry' => 'bool',
		]);
		
		if ($options['limit'] < 1)
		{
			$options['limit'] = 1;
		}

		return true;
	}
}