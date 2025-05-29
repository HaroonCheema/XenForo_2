<?php

namespace FS\TractorLandingPageApi\XF\Api\Controller;

class Threads extends XFCP_Threads
{

    public function actionGetAuctionsListing()
    {
        $allThreads = [];
        $page = 1;
        $perPage = (int) \XF::options()->fs_tractorbynet_marketplace_listings;
        $nodeIds = \XF::options()->fs_tractorbynet_auction_id;
        $count = count($nodeIds);

        if ($count) {

            $base = intdiv($perPage, $count);
            $remainder = $perPage % $count;

            $nodeQuotaMap = [];

            foreach ($nodeIds as $nodeId) {
                $quota = $base + ($remainder > 0 ? 1 : 0);
                $nodeQuotaMap[$nodeId] = $quota;
                $remainder--;
            }

            foreach ($nodeQuotaMap as $nodeId => $quota) {
                /** @var \XF\Finder\Thread $threadFinder */
                $threadFinder = $this->finder('XF:Thread')
                    ->with('api')
                    ->where('discussion_type', '!=', 'redirect')
                    ->where('node_id', $nodeId)
                    ->order('post_date', 'desc')
                    ->limitByPage($page, $quota);

                $threads = $threadFinder->fetch();

                foreach ($threads as $thread) {
                    $allThreads[] = $thread;
                }
            }
        }

        return $this->apiResult([
            'threads' => $allThreads
            // 'threads' => \XF::asApiResult($allThreads)
        ]);
    }
}
