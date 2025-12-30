<?php

namespace FS\ArticleSearch\Widget;

use XF\Widget\AbstractWidget;

class ArticleSearchWidg extends AbstractWidget
{

    protected $defaultOptions = [
        'node_id' => '',
    ];

    protected function getDefaultTemplateParams($context)
    {
        $params = parent::getDefaultTemplateParams($context);
        if ($context == 'options') {

            // $applicableForumIds = \XF::options()->fs_custom_select_forums;

            // $nodeList = \XF::finder('XF:Node')->where("node_id", $applicableForumIds)->order('lft')->fetch();

            $nodeRepo = $this->app->repository('XF:Node');
            $params['nodeTree'] = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());
            // $params['nodeTree'] = $nodeRepo->createNodeTree($nodeList);

        }

        return $params;
    }

    public function render()
    {
        $request = \XF::app()->request();
        $options = $this->options;

        // $specificForumId = \XF::options()->fs_article_forum_id;

        // $forum = $this->contextParams['forum'];

        // if ($forum && $forum->node_id && $specificForumId) {
        //     if ($forum->node_id != $specificForumId) {
        //         return;
        //     }
        // }

        $input = $this->convertShortSearchInputNames();

        $searcher = $this->app->search();
        $type = $input['search_type'] ?: $request->filter('type', 'str');

        // /** @var \XF\Repository\Node $nodeRepo */
        // $nodeRepo = \XF::repository('XF:Node');
        // $nodeTree = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());

        $viewParams = [
            'type' => $type,
            'input' => $input,
            'node_id' => $options['node_id'] ?? '',
            // 'nodeTree' => $nodeTree
        ];

        return $this->renderer('fs_article_serach_widget', $viewParams);
    }

    protected function convertShortSearchInputNames()
    {

        $request = \XF::app()->request();

        $input = $request->filter([
            't' => 'str',
            'q' => 'str',
            'c' => 'array',
            'g' => 'bool',
            'o' => 'str'
        ]);

        return [
            'search_type' => $input['t'] ?: null,
            'keywords' => $input['q'],
            'c' => $input['c'],
            'grouped' => $input['g'] ? 1 : 0,
            'order' => $input['o'] ?: null
        ];
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            'node_id' => 'uint',
        ]);

        if (!$options['node_id']) {
            $options['node_id'] = '';
        }

        return true;
    }

    // public function getOptionsTemplate()
    // {
    //     return null;
    // }
}
