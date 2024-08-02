<?php

namespace FS\CustomForumWidget\Widget;

use XF\Widget\AbstractWidget;

class CustomForumWidget extends AbstractWidget
{
    protected $defaultOptions = [
        'limit' => 5,
        'dateLimit' => 90,
        'order' => 'newest',
        'node_ids' => []
    ];

    protected function getDefaultTemplateParams($context)
    {
        $params = parent::getDefaultTemplateParams($context);
        if ($context == 'options') {
            $nodeRepo = $this->app->repository('XF:Node');
            $params['nodeTree'] = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());
        }
        return $params;
    }

    public function render()
    {
        $finder = $this->finder('FS\GameReviews:GameReviews');

        $finder->order('review_id', 'DESC');

        $page = 1;
        $perPage = 5;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'reviews' => $finder->fetch(),
        ];

        return $this->renderer('widget_custom_forum_widget', $viewParams);
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            // 'member_stat_key' => 'str',
            'limit' => 'uint',
            'dateLimit' => 'uint',
            'node_ids' => 'array-uint',
            'order' => 'str',
        ]);

        // $memberStat = $this->findOne('XF:MemberStat', [
        //     'member_stat_key' => $options['member_stat_key']
        // ]);
        // if (!$memberStat) {
        //     $error = \XF::phrase('no_member_stat_could_be_found_for_id_provided');
        // }

        if ($options['limit'] < 1) {
            $options['limit'] = 1;
        }

        return true;
    }
}
