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

    public function actionDetail(ParameterBag $params)
    {
        $cromEmailLog = $this->assertDataExists($params->id);

        $emailLogs = \XF::finder('FS\SendMailFromTable:MidNightEmails')
            // ->where('date', '>=', $cromEmailLog->from)
            // ->where('date', '<=', $cromEmailLog->to)
            ->where('id', $cromEmailLog['email_ids'])
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

    public function actionSend(ParameterBag $params)
    {
        $midNightEmail = $this->assertEmailDataExists($params->id);

        $message = \XF::options()->fs_send_message_on_whatsapp;

        $phoneNum = $midNightEmail['phone_no'];

        if (!$message || !$phoneNum) {
            $this->noPermission();
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNum);

        $encodedMessage = urlencode($message);

        $whatsAppUrl = "https://wa.me/{$cleanPhone}?text={$encodedMessage}";

        return $this->redirect($whatsAppUrl);
    }

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

    protected function assertEmailDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\SendMailFromTable:MidNightEmails', $id, $extraWith, $phraseKey);
    }
}
