<?php

namespace FS\GenerateLink\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class GenerateLink extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('XF:Navigation')->where('forum_ids', '!=', '');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'data' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),

            'totalReturn' => count($finder->fetch()),
        ];

        return $this->view('FS\GenerateLink:GenerateLink\Index', 'fs_generate_link_index', $viewParams);
    }
}
