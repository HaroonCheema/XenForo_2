<?php

namespace ThemeHouse\Monetize\Api\Controller;

use XF;
use XF\Api\Controller\AbstractController;
use XF\Api\Mvc\Reply\ApiResult as ApiResultReply;
use XF\Mvc\Entity\Repository;
use XF\Mvc\ParameterBag;

class Sponsors extends AbstractController
{
    public function actionGet()
    {
        $featured = null;
        if ($this->request->exists('featured')) {
            $featured = $this->filter('featured', 'bool');
        }

        $sponsors = $this->getSponsorRepo()->fetchSponsors($featured);

        return $this->apiResult([
            'sponsors' => $sponsors->toApiResults(),
        ]);
    }

    protected function getSponsorRepo()
    {
        return $this->repository('ThemeHouse\Monetize:Sponsor');
    }

    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertApiScopeByRequestMethod('th_monetize_sponsors');
    }
}