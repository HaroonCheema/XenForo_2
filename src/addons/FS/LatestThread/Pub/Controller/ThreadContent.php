<?php



namespace FS\LatestThread\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class ThreadContent extends AbstractController
{
    protected function getForumFilterInput(\XF\Entity\Forum $forum)
	{
		$filters = [];

		$input = $this->filter([
			'prefix_id' => 'uint',
			'starter' => 'str',
			'starter_id' => 'uint',
			'last_days' => 'int',
			'order' => 'str',
			'direction' => 'str',
			'no_date_limit' => 'bool',
			'thread_type' => 'str'
		]);

		if ($input['no_date_limit'])
		{
			$filters['no_date_limit'] = $input['no_date_limit'];
		}

		if ($input['prefix_id'] && $forum->isPrefixValid($input['prefix_id']))
		{
			$filters['prefix_id'] = $input['prefix_id'];
		}

		if ($input['starter_id'])
		{
			$filters['starter_id'] = $input['starter_id'];
		}
		else if ($input['starter'])
		{
			$user = $this->em()->findOne('XF:User', ['username' => $input['starter']]);
			if ($user)
			{
				$filters['starter_id'] = $user->user_id;
			}
		}

		if (
			($input['last_days'] > 0 && $input['last_days'] != $forum->list_date_limit_days)
			|| ($input['last_days'] < 0 && $forum->list_date_limit_days)
		)
		{
			if (in_array($input['last_days'], $this->getAvailableDateLimits($forum)))
			{
				$filters['last_days'] = $input['last_days'];
			}
		}

		$sorts = $this->getAvailableForumSorts($forum);

		if ($input['order'] && isset($sorts[$input['order']]))
		{
			if (!in_array($input['direction'], ['asc', 'desc']))
			{
				$input['direction'] = 'desc';
			}

			if ($input['order'] != $forum->default_sort_order || $input['direction'] != $forum->default_sort_direction)
			{
				$filters['order'] = $input['order'];
				$filters['direction'] = $input['direction'];
			}
		}

		if ($input['thread_type'] && $forum->TypeHandler->isThreadTypeAllowed($input['thread_type'], $forum))
		{
			$filters['thread_type'] = $input['thread_type'];
		}

		$filters = $forum->TypeHandler->getForumFilterInput($forum, $this->request, $filters);

		return $filters;
	}
	
	protected function getAvailableForumSorts(\XF\Entity\Forum $forum)
	{
		return $forum->TypeHandler->getThreadListSortOptions($forum);
	}
public function actionIndex(ParameterBag $params)
	{
		$filterNodes=\XF::Options()->fs_filter_node;
		
	$forums = $this->repository('XF:Forum')->getViewableForums(['node_id'=>$filterNodes]);
	$forum= $forums->first();




		$page = $this->filterPage();
		$perPage = $this->options()->discussionsPerPage;
		$threadFinder = $this->getThreadRepo()->findThreadsWithLatestPosts();
		$threadFinder
			->where('discussion_state', 'visible')
			->where('node_id', $forums->keys())
			->limitByPage($page, $perPage);

		$total = $threadFinder->total();
		$threads = $threadFinder->fetch()->filterViewable();

		/** @var \XF\Entity\Thread $thread */
		$canInlineMod = false;
		foreach ($threads AS $threadId => $thread)
		{
			if ($thread->canUseInlineModeration())
			{
				$canInlineMod = true;
				break;
			}
		}

	   $userGroupRepo = \XF::repository('XF:ThreadPrefix');

		$choices = $userGroupRepo->getVisiblePrefixListData();



		$viewParams = [
			'page' => $page,
			'perPage' => $perPage,
			'total' => $total,
			'forums'=>$forums,
			'prefixGroup1' => $choices['prefixesGrouped'][\XF::Options()->prefix_group_1],
			'prefixGroup2' => $choices['prefixesGrouped'][\XF::Options()->prefix_group_2],
			'prefixGroup3' => $choices['prefixesGrouped'][\XF::Options()->prefix_group_3],
			'threads' => $threads->filterViewable(),
		     
			'canInlineMod' => $canInlineMod,
			'sortOptions'=>$this->getAvailableForumSorts($forum)
		

		];
		return $this->view('XF:FindThreads\List', 'forum_view_latest_content', $viewParams);
		

	}

		protected function getThreadRepo()
	{
		return $this->repository('XF:Thread');
	}
   
}
