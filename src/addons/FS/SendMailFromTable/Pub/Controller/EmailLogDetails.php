<?php

namespace FS\SendMailFromTable\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class EmailLogDetails extends AbstractController
{
    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertRegistrationRequired();

        $visitor = \XF::visitor();

        if (!$visitor->is_admin && !$visitor->is_moderator) {
            throw $this->exception(
                $this->noPermission()
            );
        }
    }

    public function actionIndex(ParameterBag $params)
    {

        $id = $params->id ?? $this->filter('id', 'str');

        $cromEmailLog = $this->assertDataExists($id);

        $emailLogs = \XF::finder('FS\SendMailFromTable:MidNightEmails')
            // ->where('date', '>=', $cromEmailLog->from)
            // ->where('date', '<=', $cromEmailLog->to)
            ->where('id', $cromEmailLog['email_ids'])
            ->order('phone_no', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $emailLogs->limitByPage($page, $perPage);

        $viewParams = [
            'emailLogsDetail' => $emailLogs->fetch(),
            'cromEmailLogId' => $cromEmailLog->id,

            'page' => $page,
            'perPage' => $perPage,
            'total' => $emailLogs->total(),
        ];

        return $this->view('FS\SendMailFromTable:EmailLogDetails\Index', 'fs_email_logs_details', $viewParams);
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
