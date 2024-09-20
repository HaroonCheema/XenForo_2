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

		if ($input['no_date_limit']) {
			$filters['no_date_limit'] = $input['no_date_limit'];
		}

		if ($input['prefix_id'] && $forum->isPrefixValid($input['prefix_id'])) {
			$filters['prefix_id'] = $input['prefix_id'];
		}

		if ($input['starter_id']) {
			$filters['starter_id'] = $input['starter_id'];
		} else if ($input['starter']) {
			$user = $this->em()->findOne('XF:User', ['username' => $input['starter']]);
			if ($user) {
				$filters['starter_id'] = $user->user_id;
			}
		}

		if (
			($input['last_days'] > 0 && $input['last_days'] != $forum->list_date_limit_days)
			|| ($input['last_days'] < 0 && $forum->list_date_limit_days)
		) {
			if (in_array($input['last_days'], $this->getAvailableDateLimits($forum))) {
				$filters['last_days'] = $input['last_days'];
			}
		}

		$sorts = $this->getAvailableForumSorts($forum);

		if ($input['order'] && isset($sorts[$input['order']])) {
			if (!in_array($input['direction'], ['asc', 'desc'])) {
				$input['direction'] = 'desc';
			}

			if ($input['order'] != $forum->default_sort_order || $input['direction'] != $forum->default_sort_direction) {
				$filters['order'] = $input['order'];
				$filters['direction'] = $input['direction'];
			}
		}

		if ($input['thread_type'] && $forum->TypeHandler->isThreadTypeAllowed($input['thread_type'], $forum)) {
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
		$filterNodes = \XF::Options()->fs_filter_node;

		$forums = $this->repository('XF:Forum')->getViewableForums(['node_id' => $filterNodes]);
		$forum = $forums->first();

		$page = $this->filterPage();
		$perPage = $this->options()->discussionsPerPage;
		$threadFinder = $this->findThreadsWithLatestPosts();

		if ($this->filter('apply', 'uint')) {
			$threadFinder = $this->getSearchFinder($threadFinder);

			$threadFinder->order('view_count', 'DESC');

			if (count($threadFinder->getConditions()) == 0) {
				return $this->error(\XF::phrase('please_complete_required_field'));
			}
		} else {
			$threadFinder
				->where('node_id', $forums->keys())
				->limitByPage($page, $perPage)
				->order('last_post_date', 'DESC');
		}

		// $threadFinder
		// 	->where('discussion_state', 'visible')
		// 	->where('node_id', $forums->keys())
		// 	->limitByPage($page, $perPage);

		$total = $threadFinder->total();
		$threads = $threadFinder->fetch()->filterViewable();

		/** @var \XF\Entity\Thread $thread */
		$canInlineMod = false;
		foreach ($threads as $threadId => $thread) {
			if ($thread->canUseInlineModeration()) {
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
			'forums' => $forums,
			'prefixGroup1' => $choices['prefixesGrouped'][\XF::Options()->prefix_group_1],
			'prefixGroup2' => $choices['prefixesGrouped'][\XF::Options()->prefix_group_2],
			'prefixGroup3' => $choices['prefixesGrouped'][\XF::Options()->prefix_group_3],

			'conditions' => $this->filterSearchConditions(),

			'threads' => $threads->filterViewable(),

			'canInlineMod' => $canInlineMod,
			'sortOptions' => $this->getAvailableForumSorts($forum)


		];
		return $this->view('XF:FindThreads\List', 'forum_view_latest_content', $viewParams);
	}

	/**
	 * @return \XF\Finder\Thread
	 */
	public function findThreadsWithLatestPosts()
	{
		return $this->finder('XF:Thread')
			->with(['Forum', 'User'])
			->where('Forum.find_new', true)
			->where('discussion_state', 'visible')
			->where('discussion_type', '<>', 'redirect')
			->where('last_post_date', '>', $this->getReadMarkingCutOff())
			->indexHint('FORCE', 'last_post_date');
	}

	public function getReadMarkingCutOff()
	{
		return \XF::$time - $this->options()->readMarkingDataLifetime * 86400;
	}

	protected function getSearchFinder($threadFinder)
	{
		$conditions = $this->filterSearchConditions();



		// echo "<pre>";
		// var_dump($array = explode(", ", $string););
		// exit;



		if (isset($conditions['thread_fields']['node_ids'])) {
			$threadFinder->where('node_id', $conditions['thread_fields']['node_ids']);
		}

		if ($conditions['last_days'] > 0 && $conditions['last_days']) {
			$currentTime = time();

			$lastUpdate = $currentTime - ($conditions['last_days'] * 24 * 60 * 60);

			$threadFinder->where('last_post_date', '<=', $lastUpdate);
		}

		if (isset($conditions['thread_fields']['node_ids'])) {
			$threadFinder->where('node_id', $conditions['thread_fields']['node_ids']);
		}

		if (isset($conditions['keywords']) && $conditions['keywords'] != '') {

			$threadFinder->where('title', 'LIKE', $threadFinder->escapeLike($conditions['keywords'], '%?%'));
		}

		if (isset($conditions['tags']) && $conditions['tags'] != '') {

			$tags = explode(", ", $conditions['tags']);
			// $tag = '"tag":"' . $conditions['tags'] . '"';

            $threadFinder->hasTag($tags);

			// $threadFinder->where('tags', 'LIKE', $threadFinder->escapeLike($tag, '%?%'));
		}

		// if (isset($conditions['extags']) && $conditions['extags'] != '') {
		// 	// $exTags = '"tag":"' . $conditions['extags'] . '"';

		// 	$exTags = explode(", ", $conditions['extags']);

        //     $threadFinder->hasTag($exTags);

		// 	// $threadFinder->where('tags', 'not like', $threadFinder->escapeLike($exTags, '%?%'));
		// }

		if ((isset($conditions['prefix_ids1']) &&  count($conditions['prefix_ids1'])) || (isset($conditions['prefix_ids2']) &&  count($conditions['prefix_ids2'])) || (isset($conditions['prefix_ids3']) &&  count($conditions['prefix_ids3']))) {

			$prefixIds1 = isset($conditions['prefix_ids1']) ? $conditions['prefix_ids1'] : [];
			$prefixIds2 = isset($conditions['prefix_ids2']) ? $conditions['prefix_ids2'] : [];
			$prefixIds3 = isset($conditions['prefix_ids3']) ? $conditions['prefix_ids3'] : [];

			$mergedArray = array_merge($prefixIds1, $prefixIds2, $prefixIds3);

			$prefixFilter = array_unique($mergedArray);

			/** @var \SV\MultiPrefix\XF\Finder\Thread $threadFinder */
			$threadFinder->hasPrefixes($prefixFilter);
		}

		$direction = $conditions['direction'] == 'asc' ? 'Asc' : 'DESC';

		$threadFinder->order($conditions['order'], $direction);

		return $threadFinder;
	}

	protected function filterSearchConditions()
	{
		return $this->filter([
			'thread_fields' => 'array',
			'last_days' => 'int',
			'order' => 'str',
			'direction' => 'str',
			'keywords' => 'str',
			'tags' => 'str',
			'extags' => 'str',
			'prefix_ids1' => 'array',
			'prefix_ids2' => 'array',
			'prefix_ids3' => 'array',
		]);
	}

	protected function getThreadRepo()
	{
		return $this->repository('XF:Thread');
	}
}
