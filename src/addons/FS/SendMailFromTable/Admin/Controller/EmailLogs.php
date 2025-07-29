<?php

namespace FS\SendMailFromTable\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

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

    public function actionDetail(ParameterBag $params)
    {
        $cromEmailLog = $this->assertDataExists($params->id);

        $emailLogs = \XF::finder('FS\SendMailFromTable:MidNightEmails')
            ->where('date', '>=', $cromEmailLog->from)
            ->where('date', '<=', $cromEmailLog->to)
            ->where('is_pending', false)
            ->order('id', 'DESC');

        $page = $params->page;
        // $perPage = 15;

        $viewParams = [
            'emailLogsDetail' => $emailLogs->fetch(),

            'page' => $page,
            // 'perPage' => $perPage,
            'perPage' => $emailLogs->total(),
            'total' => $emailLogs->total(),
        ];

        return $this->view('FS\SendMailFromTable:EmailLogs\Index', 'fs_email_logs_details', $viewParams);
    }

    // plugin for check id exists or not 

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\SendMailFromTable\Entity\EmailTemplates
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\SendMailFromTable:CronEmailLogs', $id, $extraWith, $phraseKey);
    }
}
