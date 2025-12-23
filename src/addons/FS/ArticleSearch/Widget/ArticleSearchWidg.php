<?php

namespace FS\ArticleSearch\Widget;

use XF\Widget\AbstractWidget;

class ArticleSearchWidg extends AbstractWidget
{
    public function render()
    {
        $request = \XF::app()->request();

        $specificForumId = \XF::options()->fs_article_forum_id;

        $forum = $this->contextParams['forum'];

        if ($forum && $forum->node_id && $specificForumId) {
            if ($forum->node_id != $specificForumId) {
                return;
            }
        }

        $input = $this->convertShortSearchInputNames();

        $searcher = $this->app->search();
        $type = $input['search_type'] ?: $request->filter('type', 'str');

        /** @var \XF\Repository\Node $nodeRepo */
        $nodeRepo = \XF::repository('XF:Node');
        $nodeTree = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());

        $viewParams = [
            'type' => $type,
            'input' => $input,
            'nodeTree' => $nodeTree
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

    public function getOptionsTemplate()
    {
        return null;
    }
}
