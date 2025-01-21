<?php

namespace AddonFlare\ForumStats\ForumStat;

class MostPopularForums extends AbstractForumStat
{
    protected $defaultOptions = [
        'limit' => 5,
        'node_ids' => [],
        'excluded_node_ids' => [],
        'ignore_view_perms' => false,
        'show_counter' => false,
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
        $ignoreViewPerms = $options['ignore_view_perms'];

        $router = $this->app->router('public');

        $forumFinder = $this->finder('XF:Forum')
            ->where('Node.display_in_list', 1)
            ->order('message_count', 'DESC')
            ->limit(max($limit * 2, 10));

        if ($nodeIds && !in_array(0, $nodeIds))
        {
            $forumFinder->where('node_id', $nodeIds);
        }

        if ($excludedNodeIds && !in_array(0, $excludedNodeIds))
        {
            $forumFinder->where('node_id', '!=', $excludedNodeIds);
        }

        foreach ($forums = $forumFinder->fetch() AS $nodeId => $forum)
        {
            if ($this->ignoreContentAddonIsIgnored($forum)
            )
            {
                unset($forums[$nodeId]);
            }
        }

        if (!$ignoreViewPerms)
        {
            $forums = $this->repository('XF:Node')->filterViewable($forums);
        }

        $total = $forums->count();
        $forums = $forums->slice(0, $limit, true);

        $viewParams = [
            'forums' => $forums,
        ];
        return $this->renderer('af_forumstats_most_popular_forums', $viewParams);
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            'limit'             => 'uint',
            'node_ids'          => 'array-uint',
            'excluded_node_ids' => 'array-uint',
            'ignore_view_perms' => 'bool',
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