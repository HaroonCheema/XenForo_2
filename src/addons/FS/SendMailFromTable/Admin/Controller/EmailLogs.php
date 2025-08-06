<?php

namespace FS\SendMailFromTable\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Admin\Controller\AbstractController;

class EmailLogs extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {

        $finder = $this->finder('FS\SendMailFromTable:CronEmailLogs')->order('id', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'emailLogs' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
        ];

        return $this->view('FS\SendMailFromTable:EmailLogs\Index', 'fs_email_logs_index', $viewParams);
    }
}
