<?php

namespace AddonFlare\ForumStats\ForumStat;

class MostReactedThreads extends AbstractForumStat
{
    protected $defaultOptions = [
        'limit' => 5,
        'node_ids' => [],
        'excluded_node_ids' => [],
        'thread_prefix' => 'html',
        'cutoff' => 30,
        'include_closed' => true,
        'ignore_view_perms' => false,
        'show_forum_title'  => false,
        'show_last_poster'  => false,
        'show_last_poster_rich' => true,
        'show_counter'      => false,
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
        $limit = $options['limit'];
        $nodeIds = $options['node_ids'];
        $excludedNodeIds = $options['excluded_node_ids'];
        $cutoff = $options['cutoff'];
        $includeClosed = $options['include_closed'];
        $ignoreViewPerms = $options['ignore_view_perms'];
        $showLastPoster = $options['show_last_poster'];

        $router = $this->app->router('public');

        /** @var \XF\Repository\Thread $threadRepo */
        $threadRepo = $this->repository('XF:Thread');

        $threadFinder = $this->finder('XF:Thread')
            ->with(['Forum', 'User'])
            ->where('discussion_state', 'visible')
            ->where('discussion_type', '<>', 'redirect')
            ->where('post_date', '>', $this->getCutOffFromDays($cutoff))
            ->order('first_post_reaction_score', 'DESC');

        if ($showLastPoster)
        {
            $threadFinder->with('LastPoster');
        }

        if (!$includeClosed)
        {
            $threadFinder->where('discussion_open', 1);
        }

        $threadFinder
            ->with('Forum.Node.Permissions|' . $visitor->permission_combination_id)
            ->limit(max($limit * 2, 10));

        $threadFinder->withReadData();

        if ($nodeIds && !in_array(0, $nodeIds))
        {
            $threadFinder->where('node_id', $nodeIds);
        }

        if ($excludedNodeIds && !in_array(0, $excludedNodeIds))
        {
            $threadFinder->where('node_id', '!=', $excludedNodeIds);
        }

        /** @var \XF\Entity\Thread $thread */
        foreach ($threads = $threadFinder->fetch() AS $threadId => $thread)
        {
            if ((!$ignoreViewPerms && !$thread->canView())
                || $thread->isIgnored()
                || $visitor->isIgnoring($thread->last_post_user_id)
                || $this->ignoreContentAddonIsIgnored($thread)
            )
            {
                unset($threads[$threadId]);
            }
        }
        $total = $threads->count();
        $threads = $threads->slice(0, $limit, true);

        $viewParams = [
            'threads' => $threads,
        ];
        return $this->renderer('af_forumstats_most_reacted_threads', $viewParams);
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            'limit'             => 'uint',
            'node_ids'          => 'array-uint',
            'excluded_node_ids' => 'array-uint',
            'thread_prefix'     => 'str',
            'cutoff'            => 'uint',
            'include_closed'    => 'uint',
            'ignore_view_perms' => 'bool',
            'show_forum_title'  => 'bool',
            'show_last_poster'  => 'bool',
            'show_last_poster_rich'  => 'bool',
            'show_counter'      => 'bool',
        ]);

        if (in_array(0, $options['node_ids']))
        {
            $options['node_ids'] = [0];
        }

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