<?php

namespace FS\ExtendNewPostsWidget\XF\Widget;

class NewPosts extends XFCP_NewPosts
{

    protected $defaultOptions = [
        'limit' => 5,
        'style' => 'simple',
        'filter' => 'latest',
        'node_ids' => [],
        'unique_node_ids' => [],
        'node_limits' => [],
    ];

    protected function getDefaultTemplateParams($context)
    {
        $params = parent::getDefaultTemplateParams($context);
        if ($context == 'options') {
            $params['limitForums'] = $this->app->finder('XF:Node')->where('node_type_id', 'Forum')->fetch();
        }
        return $params;
    }

    public function render()
    {
        $visitor = \XF::visitor();

        $options = $this->options;
        $limit = $options['limit'];
        $filter = $options['filter'];
        $nodeIds = $options['node_ids'];

        $node_limits = $options['node_limits'];

        if (!$visitor->user_id) {
            $filter = 'latest';
        }

        $router = $this->app->router('public');


        $threadRepo = $this->repository('XF:Thread');

        switch ($filter) {
            default:
            case 'latest':
                $threadFinder = $threadRepo->findThreadsWithLatestPosts();
                $title = \XF::phrase('widget.latest_posts');
                $link = $router->buildLink('whats-new/posts', null, ['skip' => 1]);
                break;

            case 'unread':
                $threadFinder = $threadRepo->findThreadsWithUnreadPosts();
                $title = \XF::phrase('widget.unread_posts');
                $link = $router->buildLink('whats-new/posts', null, ['unread' => 1]);
                break;

            case 'watched':
                $threadFinder = $threadRepo->findThreadsForWatchedList();
                $title = \XF::phrase('widget.latest_watched');
                $link = $router->buildLink('whats-new/posts', null, ['watched' => 1]);
                break;
        }

        $loopTerminate = true;



        if (isset($options['unique_node_ids']) && count($options['unique_node_ids']) && $limit) {

            $unique_node_ids = $options['unique_node_ids'];

            $node_limits = $options['node_limits'];

            $isfirst = 1;

            foreach ($unique_node_ids as $key => $unique_node_id) {

                $nodelimit = intval($node_limits[$key]);


                if ($nodelimit == -1 && $limit != 0) {

                    $nodelimit = $limit;
                }

                if ($limit > $nodelimit && $limit != 0) {

                    $limit = $limit - $nodelimit;
                } elseif ($limit < $nodelimit && $limit != 0) {

                    $nodelimit = $limit;

                    $limit = 0;
                } elseif ($nodelimit == $limit && $limit != 0) {

                    $nodelimit = $nodelimit;
                    $limit = $limit - $nodelimit;
                }

                if ($isfirst == 1 && $loopTerminate) {

                    $firstthreadFinder = $threadFinder;
                    $firstthreadFinder->with('Forum.Node.Permissions|' . $visitor->permission_combination_id);

                    if ($options['style'] == 'full') {
                        $firstthreadFinder->with('fullForum');
                    } else {
                        $firstthreadFinder
                            ->with('LastPoster')
                            ->withReadData();
                    }



                    if ($nodelimit < 0) {

                        $threads = $firstthreadFinder->where('node_id', $unique_node_id)->fetch();
                    } else {

                        $threads = $firstthreadFinder->where('node_id', $unique_node_id)->fetch($nodelimit);
                    }

                    $isfirst = 0;
                } elseif ($loopTerminate) {

                    if ($filter == "latest") {

                        $threadFinder = $threadRepo->findThreadsWithLatestPosts();
                    } elseif ($filter == "unread") {

                        $threadFinder = $threadRepo->findThreadsWithUnreadPosts();
                    } elseif ($filter == "watched") {

                        $threadFinder = $threadRepo->findThreadsForWatchedList();
                    }

                    $threadFinder->with('Forum.Node.Permissions|' . $visitor->permission_combination_id);

                    if ($options['style'] == 'full') {

                        $threadFinder->with('fullForum');
                    } else {
                        $threadFinder
                            ->with('LastPoster')
                            ->withReadData();
                    }

                    if ($nodelimit < 0) {

                        $limitThreads = $threadFinder->where('node_id', $unique_node_id)->fetch();
                    } else {

                        $limitThreads = $threadFinder->where('node_id', $unique_node_id)->fetch($nodelimit);
                    }

                    if (count($limitThreads)) {

                        $threads = $threads->merge($limitThreads);
                    }
                }

                if ($limit == 0) {

                    $loopTerminate = false;
                }
            }

            foreach ($threads as $threadId => $thread) {
                if (
                    !$thread->canView() || $thread->isIgnored() || $visitor->isIgnoring($thread->last_post_user_id)
                ) {
                    unset($threads[$threadId]);
                }
            }

            $total = $threads->count();

            $viewParams = [
                'title' => $this->getTitle() ?: $title,
                'link' => $link,
                'threads' => $threads,
                'style' => $options['style'],
                'filter' => $filter,
                'hasMore' => $total > $threads->count()
            ];
            return $this->renderer('widget_new_posts', $viewParams);
        }

        return parent::render();
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {

        $options = $request->filter([
            'limit' => 'uint',
            'style' => 'str',
            'filter' => 'str',
            'node_ids' => 'array-uint',
            'unique_node_ids' => 'array',
            'node_limits' => 'array-int',
            'display_limit' => 'array-int',
        ]);

        if (count($options['node_limits'])) {

            foreach ($options['node_limits'] as $key => $limit) {

                if ($limit == 0) {

                    unset($options['node_limits'][$key]);
                }

                if ($limit < -1) {

                    unset($options['node_limits'][$key]);
                }
            }
        }

        if (count($options['unique_node_ids'])) {

            foreach ($options['unique_node_ids'] as $key => $nodeId) {

                if ($nodeId == 0) {

                    unset($options['unique_node_ids'][$key]);
                    unset($options['node_limits'][$key]);
                }

                if (!isset($options['node_limits'][$key])) {

                    unset($options['unique_node_ids'][$key]);
                }
            }
        }

        if (in_array(0, $options['node_ids'])) {
            $options['node_ids'] = [0];
        }
        if ($options['limit'] < 1) {
            $options['limit'] = 1;
        }

        return true;
    }
}
