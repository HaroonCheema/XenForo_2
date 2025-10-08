<?php

namespace FS\ReviewsMap\XF\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

class Log extends XFCP_Log
{
    public function actionReviewmap()
    {
        /** @var \FS\ReviewsMap\Repository\SitemapLog $sitemapRepo */
        $sitemapRepo = $this->repository('FS\ReviewsMap:ReviewmapLog');

        $viewParams = [
            'entries' => $sitemapRepo->findReviewmapLogsForList()->fetch()
        ];
        return $this->view('XF:Log\Sitemap\Listing', 'fs_log_sitemap_list', $viewParams);
    }
}
