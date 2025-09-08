<?php

namespace XenGenTr\XGTForumistatistik\Widget;

use \XF\Widget\AbstractWidget;

class EncokGoruntulenen extends AbstractForumIstatistik
{
    protected $defaultOptions = [
        'limit' => 5,
        'excluded_node_ids' => [],
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

        $limit = \XF::options()->xgtIstatistikGosterimLimiti;

        $excludedNodeIds = $options['excluded_node_ids'];

	    $router = $this->app->router('public');

		/** @var \XF\Finder\Thread $threadFinder */
		$threadFinder = $this->finder('XF:Thread');
		$threadFinder
		    ->with(['Forum', 'User'])
			->with('Forum.Node.Permissions|' . $visitor->permission_combination_id)
			->where('discussion_state', 'visible')
			->where('discussion_type', '<>', 'redirect')
			->where('view_count', '>', 1)
			->order('view_count', 'DESC')
			->limit(max($limit * 2, 10));


        if ($excludedNodeIds && !in_array(0, $excludedNodeIds))
        {
            $threadFinder->where('node_id', '!=', $excludedNodeIds);
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
            'threads' => $threads,
        ];

		return $this->renderer('xgt_FrmIstatistik_enCok_goruntuleme', $viewParams);
	}

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            'limit'             => 'uint',
            'excluded_node_ids' => 'array-uint',
        ]);

        if ($options['limit'] < 1)
        {
            $options['limit'] = 1;
        }

        if (in_array(0, $options['excluded_node_ids']))
        {
            $options['excluded_node_ids'] = [0];
        }

        return true;
    }
}