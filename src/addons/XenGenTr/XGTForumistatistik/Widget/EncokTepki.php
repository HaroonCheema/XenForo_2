<?php

namespace XenGenTr\XGTForumistatistik\Widget;

use XF\Widget\AbstractWidget;

class EncokTepki extends AbstractForumIstatistik
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

        /** @var \XF\Repository\Thread $threadRepo */
        $threadRepo = $this->repository('XF:Thread');

        $threadFinder = $this->finder('XF:Thread')
            ->with(['Forum', 'User'])
            ->where('discussion_state', 'visible')
            ->where('discussion_type', '<>', 'redirect')
            ->order('first_post_reaction_score', 'DESC');

        $threadFinder
            ->with('Forum.Node.Permissions|' . $visitor->permission_combination_id)
            ->limit(max($limit * 2, 10));

        $threadFinder->withReadData();

        if ($excludedNodeIds && !in_array(0, $excludedNodeIds))
        {
            $threadFinder->where('node_id', '!=', $excludedNodeIds);
        }

        /** @var \XF\Entity\Thread $thread */
        foreach ($threads = $threadFinder->fetch() AS $threadId => $thread)
        {
            if ((!$thread->canView())
                || $visitor->isIgnoring($thread->user_id)
            )
            {
                unset($threads[$threadId]);
            }

            if ($visitor->isIgnoring($thread->last_post_user_id))
            {
                unset($threads[$threadId]);
            }
        }
        $total = $threads->count();
        $threads = $threads->slice(0, $limit, true);

        $viewParams = [
            'threads' => $threads,
        ];
        return $this->renderer('xgt_FrmIstatistik_enCok_tepki', $viewParams);
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