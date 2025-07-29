<?php

namespace FS\SendMailFromTable\Job;

// use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel;

use XF\Job\AbstractJob;

class SendEmails extends AbstractJob
{
    protected $defaultData = [
        'emailNextCounter' => 0,
        'nextRunAt' => 0,
        'count' => 0,
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);

        $options = \XF::options();

        $templateId = $options->fs_email_from_table_template_ids;
        $emailsPerMinute = $options->fs_send_emails_per_minute;

        if (!$templateId) {
            return $this->complete();
        }

        $emailTemplate = \xf::app()->em()->find('FS\SendMailFromTable:EmailTemplates', $templateId);

        if (!$emailTemplate) {
            return $this->complete();
        }

        // $baseDate = DateTimeExcel\Current::now();
        // $baseDate = strtotime('-7 days', $baseDate);

        $now = time();
        $todayMidnight = strtotime('today midnight');
        $yesterdayMidnight = $todayMidnight - 86400;

        $pendingEmails = \XF::finder('FS\SendMailFromTable:MidNightEmails')->where('date', '>=', $yesterdayMidnight)->where('date', '<=', $todayMidnight)->where('is_pending', true)->fetch();

        if (!$pendingEmails->count()) {

            return $this->complete();
        }

        if ($this->data['count'] == 0) {
            $this->data['emailNextCounter'] = $emailsPerMinute;

            $emailLog = \xf::app()->em()->create('FS\SendMailFromTable:CronEmailLogs');

            $emailLog->bulkSet([
                'from' => $yesterdayMidnight,
                'to' => $todayMidnight,
            ]);
            $emailLog->save();
        }

        if ($this->data['nextRunAt'] > time()) {
            return $this->resume();
        }

        $email = [
            'from_name' => $options->emailSenderName ? $options->emailSenderName : $options->boardTitle,
            'from_email' => $options->defaultEmailAddress,
            'email_body' => $emailTemplate->email_body,
            'email_title' => $emailTemplate->title,
            'email_format' => 'html',
            'email_wrapped' => true,
            'email_unsub' => false,
        ];

        // $language = $this->app->userLanguage($user);
        $language = $this->app->language(0);

        $email['email_body'] = $this->replacePhrases($email['email_body'], $language);
        $email['email_title'] = $this->replacePhrases($email['email_title'], $language);

        // if ($email['email_format'] == 'html') {
        //     if ($email['email_unsub']) {
        //         $email['email_body'] .= "\n\n<div class=\"minorText\" align=\"center\"><a href=\"{unsub}\">"
        //             . $language->renderPhrase('unsubscribe_from_mailing_list')
        //             . '</a></div>';
        //     }
        // }

        foreach ($pendingEmails as $key => $emailData) {

            $this->data['count']++;

            $tokens = $this->prepareToken($emailData->email);
            $html = strtr($email['email_body'], $tokens);
            $text = $this->app->mailer()->generateTextBody($html);

            $title = strtr($email['email_title'], $tokens);

            $mail = $this->getMail($emailData)->setFrom($email['from_email'], $email['from_name']);
            $mail->setTemplate('prepared_email', [
                'title' => $title,
                'htmlBody' => $html,
                'textBody' => $text,
                'raw' => $email['email_wrapped'] ? false : true
            ]);
            $mail->send();

            $emailData->bulkSet([
                'is_pending' => false,
            ]);

            $emailData->save();

            if ($this->data['count'] == $this->data['emailNextCounter']) {
                $this->data['emailNextCounter'] += $emailsPerMinute;

                $this->data['nextRunAt'] = time() + 60; // Set next run time to 1 minute later

                return $this->resume();
            }

            if (microtime(true) - $startTime >= $maxRunTime) {
                break;
            }
        }

        return $this->resume();
    }

    protected function prepareToken($email)
    {
        $tokens = [
            '{name}' => "",
            '{email}' => $email,
            '{id}' => "",
            '{unsub}' => ""
        ];

        return $tokens;
    }

    protected function getMail($emailData)
    {
        $mailer = $this->app->mailer();
        $mail = $mailer->newMail();

        $options = $this->app->options();
        $unsubEmail = $options->unsubscribeEmailAddress;
        $useVerp = $options->enableVerp;

        // $mail->setToUser($emailData);

        $mail->setTo($emailData->email);

        return $mail->setListUnsubscribe($unsubEmail, $useVerp);
    }

    protected function replacePhrases($string, \XF\Language $language)
    {
        return $this->app->stringFormatter()->replacePhrasePlaceholders($string, $language);
    }

    public function writelevel() {}

    public function getStatusMessage()
    {
        return \XF::phrase('processing_successfully...');
    }

    public function canCancel()
    {
        return false;
    }

    public function canTriggerByChoice()
    {
        return false;
    }
}
