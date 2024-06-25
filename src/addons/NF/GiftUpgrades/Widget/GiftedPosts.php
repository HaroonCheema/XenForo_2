<?php
/**
 * @noinspection PhpMissingReturnTypeInspection
 */

namespace NF\GiftUpgrades\Widget;

use XF\Mvc\Entity\ArrayCollection;
use XF\Widget\AbstractWidget;

/**
 * Class GiftedPosts
 *
 * @package NF\GiftUpgrades\Widget
 */
class GiftedPosts extends AbstractWidget
{
    protected $defaultOptions = [
        'limit' => 5,
        'dateLimit' => 90,
        'snippetLength' => 50,
        'skipLockedThreads' => false,
        'skipWarnedPosts' => true,
        'skipPrefixes' => [],
        'cacheTime' => 300,
        'style' => 'simple',
        'node_ids' => [],
    ];

    /**
     * @param $context
     *
     * @return array
     */
    protected function getDefaultTemplateParams($context)
    {
        $params = parent::getDefaultTemplateParams($context);
        if ($context === 'options')
        {
            /** @var \XF\Repository\Node $nodeRepo */
            $nodeRepo = $this->app->repository('XF:Node');
            $fullNodeList = $nodeRepo->getFullNodeList();
            $params['nodeTree'] = $nodeRepo->createNodeTree($fullNodeList);

            /** @var \XF\Repository\ThreadPrefix $prefixRepo */
            $prefixRepo = $this->repository('XF:ThreadPrefix');
            $availablePrefixes = $prefixRepo->findPrefixesForList()->fetch()->pluckNamed('title', 'prefix_id');

            $params['prefixList'] = $availablePrefixes;
        }
        return $params;
    }

    public function render()
    {
        $limit = (int)$this->options['limit'];
        $nodeIds = $this->options['node_ids'];

        /** @var \XF\Repository\Node $nodeRepo */
        $nodeRepo = $this->repository('XF:Node');
        $nodes = $nodeRepo->getNodeList();
        if ($nodeIds)
        {
            $nodeIds = \array_fill_keys($nodeIds, true);
            $nodes = $nodes->filter(function (\XF\Entity\Node $node) use ($nodeIds) {
                return isset($nodeIds[$node->node_id]) && $node->node_type_id === 'Forum';
            });
        }
        else
        {
            $nodes = $nodes->filter(function (\XF\Entity\Node $node) {
                return $node->node_type_id === 'Forum';
            });
        }
        $forumIds = $nodes->keys();

        $app = \XF::app();
        $options = \XF::options();
        $cutOffTime = 86400 * (int)($this->options['dateLimit'] ?? $options->readMarkingDataLifetime);

        $cacheTime = (int)($this->options['cacheTime'] ?? 300);
        $skipLockedThreads = (bool)($this->options['skipLockedThreads'] ?? false);
        $skipWarnedPosts = (bool)($this->options['skipWarnedPosts'] ?? true);
        $skipPrefixes = $this->options['skipPrefixes'];
        $skipPrefixes  = $skipPrefixes && is_array($skipPrefixes) ? array_unique(array_map('\intval', $skipPrefixes)) : [];
        $giftOptions = [
            'skipPrefixes' => $skipPrefixes,
            'skipLockedThreads' => $skipLockedThreads,
            'skipWarnedPosts' => $skipWarnedPosts,
        ];
        $cacheKey = 'nf_gifted_post_'.md5(implode(',',$forumIds) . '.' . $limit . '.' . $cacheTime . '.' . $cutOffTime . '.'. \json_encode($giftOptions));
        $postIds = false;
        $cache = null;
        if ($cacheTime && $cache = $app->cache())
        {
            $postIds = $cache->fetch($cacheKey);
            if ($postIds !== false)
            {
                $postIds = array_filter(array_map('intval', explode(',',$postIds)));
            }
        }

        if (!is_array($postIds))
        {
            $postIds = $this->getPostIds($forumIds, $cutOffTime, $limit*2, $giftOptions);
            if ($cache)
            {
                $cache->save($cacheKey, implode(',', $postIds), $cacheTime);
            }
        }
        if ($postIds)
        {
            $unsortedPosts = $this->getGiftedPostsFinder($postIds)->fetch();
            $posts = $unsortedPosts->sortByList($postIds);
        }
        else
        {
            $posts = new ArrayCollection([]);
        }

        $posts = $posts->filterViewable();
        $posts = $posts->slice(0, $limit, true);

        $viewParams = [
            'title'       => $this->getTitle() ?: \XF::phrase('widget_def.nfRecentGiftUpgrades'),
            //'link'        => $this->app->router('public')->buildLink('whats-new/gifted-posts'),
            'posts' => $posts,
            'style' => $this->options['style'],
            'snippetLength' => (int)$this->options['snippetLength'],
        ];

        return $this->renderer('svGiftUpgrades_widget_gifted_posts', $viewParams);
    }

    /**
     * @param int[] $postIds
     * @return \XF\Mvc\Entity\Finder
     */
    protected function getGiftedPostsFinder(array $postIds)
    {
        return \XF::finder('XF:Post')
                  ->whereIds($postIds)
                  ->with($this->getEntityWith());
    }

    public function getEntityWith(): array
    {
        $visitor = \XF::visitor();

        $with = ['User', 'Thread', 'Thread.Forum', 'Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id];

        $userId = $visitor->user_id;
        if ($userId)
        {
            $with[] = 'Thread.Read|' . $userId;
        }

        return $with;
    }

    /**
     * @param int[] $forumIds
     * @param int   $cutoffDate
     * @param int   $limit
     * @param array $options
     * @return int[]
     */
    protected function getPostIds(array $forumIds, int $cutoffDate, int $limit, array $options): array
    {
        if (!$forumIds)
        {
            return [];
        }
        $db = $this->db();

        [$whereSql, $joinSql] = $this->prepareGiftPostWhereClause($forumIds, $cutoffDate, $limit, $options);
        if ($whereSql)
        {
            $whereSql = 'AND ' . $whereSql;
        }
        $quotedForumIds = $db->quote($forumIds);

        // the subquery appears to perform better...
        /** @noinspection SqlResolve */
        /** @noinspection SqlSignature */
        return $db->fetchAllColumn(
            "
            SELECT content.content_id
            FROM xf_nf_gifted_content as content
            where content.gift_date > ? and content_type = 'post' and exists
            (
                select post_id
                from xf_post as post
                JOIN xf_thread as thread on thread.thread_id =  post.thread_id
                $joinSql
                where
                    post.post_id = content.content_id and post.message_state = 'visible' and
                    thread.discussion_state = 'visible' and thread.node_id in ($quotedForumIds)
                    $whereSql
            )
            order by content.gift_date DESC 
            limit $limit
        ", [$cutoffDate]
        );
        /*
        return $db->fetchAllColumn(
            "
            SELECT distinct post.post_id
            FROM xf_nf_gifted_content as content
            JOIN xf_post as post on (post.post_id = content.content_id and content_type = 'post')
            JOIN xf_thread as thread on thread.thread_id =  post.thread_id
            WHERE content.gift_date > ? and
              thread.node_id in ($quotedForumIds) and thread.discussion_state = 'visible' and
              post.message_state = 'visible'
            order by content.gift_date DESC
            limit $limit
        ", [$cutoffDate]
        );
        */
    }

    /**
     * @param int[] $forumIds
     * @param int   $cutoffDate
     * @param int   $limit
     * @param array $options
     * @return array
     * @noinspection PhpUnusedParameterInspection
     */
    protected function prepareGiftPostWhereClause(array $forumIds, int $cutoffDate, int $limit, array $options): array
    {
        $db = $this->db();
        $sql = [];
        $join = '';

        if (!empty($options['skipLockedThreads']))
        {
            $sql[] = '(thread.discussion_open = 1)';
        }

        if (!empty($options['skipWarnedPosts']))
        {
            $sql[] = '(post.warning_id = 0)';
        }

        if (!empty($options['skipPrefixes']))
        {
            $skipPrefixes = $db->quote($options['skipPrefixes']);
            $sql[] = "(thread.prefix_id not in ($skipPrefixes))";
            $addOns = \XF::app()->container('addon.cache');
            if (isset($addOns['SV/MultiPrefix']))
            {
                $sql[] = "not exists (select thread_id from xf_sv_thread_prefix_link link where link.thread_id = thread.thread_id and link.prefix_id in ($skipPrefixes))";
            }
        }

        return [
            join(' AND ', $sql),
            $join,
        ];
    }

    /**
     * @param \XF\Http\Request $request
     * @param array            $options
     * @param null             $error
     * @return bool
     */
    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $options = $request->filter([
            'limit' => 'uint',
            'dateLimit' => 'uint',
            'style' => 'str',
            'node_ids' => 'array-uint',
            'snippetLength' => 'uint',
            'skipLockedThreads' => 'bool',
            'skipWarnedPosts' => 'bool',
            'skipPrefixes' => 'array-uint',
            'cacheTime' => 'uint',
        ]);

        if (\in_array(0, $options['node_ids'], true))
        {
            $options['node_ids'] = [];
        }

        if (\in_array(0, $options['skipPrefixes'], true))
        {
            $options['skipPrefixes'] = [];
        }

        return true;
    }
}