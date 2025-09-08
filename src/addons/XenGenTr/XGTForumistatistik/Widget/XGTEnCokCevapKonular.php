<?php

namespace XenGenTr\XGTForumistatistik\Widget;

use XF\Widget\AbstractWidget;

class XGTEnCokCevapKonular extends AbstractWidget
{
	protected $defaultOptions = [
		'style' => 'full',
		'filter' => 'latest',
		'node_ids' => []
	];

	protected function getDefaultTemplateParams($context)
	{
		$params = parent::getDefaultTemplateParams($context);
		if ($context == 'options')
		{
			$nodeRepo = $this->app->repository('XF:Node');
			$params['nodeTree'] = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());
		}
		return $params;
	}

  public function render()
	{
		$visitor = \XF::visitor();
		$options = $this->options;
        $limit = \XF::options()->XGT_istatistik_EnCokCevap_konu_limiti;
	    $filter = $options['filter'];

	    $nodeIds = \XF::options()->XGT_istatistik_EnCokCevap_konu_forumlari;

		if (!$visitor->user_id)
		{
			$filter = 'latest';
		}

		$router = $this->app->router('public');
		
		if ($headerUrl != '')
		{
			$link = $router->buildLink($headerUrl);
		}
		else
		{
			$link = false;
		}

		/** @var \XF\Finder\Thread $threadFinder */
		$threadFinder = $this->finder('XF:Thread');
		$threadFinder
		    ->with(['Forum', 'User'])
			->with('Forum.Node.Permissions|' . $visitor->permission_combination_id)
			->where('discussion_state', 'visible')
			->where('discussion_type', '<>', 'redirect')
			->where('reply_count', '>', 0)
			->order('reply_count', 'DESC')
			->limit(max($limit * 2, 10));

		if ($nodeIds && !in_array(0, $nodeIds))
		{
			$threadFinder->where('node_id', $nodeIds);
		}

		if ($style == 'full' || $style == 'expanded')
		{
			$threadFinder->forFullView(true);
			if ($style == 'expanded')
			{
				$threadFinder->with('FirstPost');
			}
		}
				 
		/** @var \XF\Entity\Thread $thread */
		foreach ($threads = $threadFinder->fetch() AS $threadId => $thread)
		{
			if (!$thread->canView()
				|| $visitor->isIgnoring($thread->user_id)
			)
			{
				unset($threads[$threadId]);
			}

			if ($options['style'] != 'expanded' && $visitor->isIgnoring($thread->last_post_user_id))
			{
				unset($threads[$threadId]);
			}
		}
		
		$total = $threads->count();
		$threads = $threads->slice(0, $limit, true);

		$viewParams = [
			'title' => $this->getTitle() ?: $title,
			'link' => $link,
			'threads' => $threads,
			'style' => $options['style'],
			'filter' => $filter,
			'hasMore' => $total > $threads->count()
		];
		return $this->renderer('XGT_istatistik_encokcevap_konular', $viewParams);
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'limit' => 'uint',
			'filter' => 'str',
			'node_ids' => 'array-uint'
		]);
		if ($options['limit'] < 1)
		{
			$options['limit'] = 1;
		}

		return true;
	}
}