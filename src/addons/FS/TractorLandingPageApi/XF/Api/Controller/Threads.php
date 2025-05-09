<?php

namespace FS\TractorLandingPageApi\XF\Api\Controller;

class Threads extends XFCP_Threads
{

    public function actionGetAuctionsListing()
    {
        $page = 1;
        $perPage = \XF::options()->fs_tractorbynet_marketplace_listings;
        $auctionId = intval(\XF::options()->fs_tractorbynet_auction_id);

        /** @var \XF\Finder\Thread $threadFinder */
        $threadFinder = $this->finder('XF:Thread')
            ->with('api')
            ->where('discussion_type', '!=', 'redirect')
            ->where('node_id', $auctionId)
            ->order('post_date', 'desc');

        $threadFinder->limitByPage($page, $perPage);

        $threads = $threadFinder->fetch();

        return $this->apiResult([
            'threads' => $threads->toApiResults()
        ]);
    }
}
