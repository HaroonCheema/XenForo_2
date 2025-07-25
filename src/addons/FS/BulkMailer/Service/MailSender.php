<?php

namespace FS\BulkMailer\Service;

class MailSender extends \XF\Service\AbstractService {

    public function processQueue() {

        $currentTime = \xf::$time;

        $mailingLists = $this->finder('FS\BulkMailer:MailingList')
                ->where([
                    'active' => 1,
                    'process_status' => [0, 1],
                ])
                ->where('next_run', '<', $currentTime)
                ->fetch();
        
       

        if (!count($mailingLists)) {
            
            return;
        }

         $app = \xf::app();

        foreach ($mailingLists as $mailingList) {

            // Set status to In Progress when starting
            if ($mailingList->process_status == 0) {
                $mailingList->process_status = 1;
                $mailingList->save();
            }

           
            $queueItems = $this->finder('FS\BulkMailer:MailQueue')
                    ->where([
                        'mailing_list_id' => $mailingList->mailing_list_id,
                        'status' => 'pending'
                    ])
                    ->fetch($mailingList->emails_per_hour);

            if (count($queueItems)) {

                foreach ($queueItems as $item) {



                    $sended = $this->sendMail($app, $item, $mailingList);

                    if ($sended) {

                        $item->status = 'sent';
                        $item->send_date = time();
                        $item->save();

                        //  $mailingList->sent_emails++;
                    } else {

                        $item->status = 'failed';
                        $item->send_date = time();
                        $item->attempts++;
                        $item->save();

                        //  $mailingList->failed_emails++;
                    }
                }
            }

            // Check for completion
            $pendingCount = $this->finder('FS\BulkMailer:MailQueue')
                    ->where([
                        'mailing_list_id' => $mailingList->mailing_list_id,
                        'status' => 'pending'
                    ])
                    ->total();

            if ($pendingCount == 0) {
                $mailingList->process_status = 2; // Set to Completed
            }

            $sendedCount = $this->finder('FS\BulkMailer:MailQueue')->where('mailing_list_id' , $mailingList->mailing_list_id)->where('status', 'sent')->fetch();

            $mailingList->sent_emails = count($sendedCount);

            $mailingList->next_run = $currentTime + 1200;

            $mailingList->save();
        }
    }

    public function sendMail($app, $item, $mailingList) {



        $options = $app->options();

        $emailData = [
            'from_name' => $mailingList->from_name ?: $options->emailSenderName,
            'from_email' => $mailingList->from_email ?: $options->defaultEmailAddress,
            'email_body' => $mailingList->description,
            'email_title' => $mailingList->subject,
            'email_format' => 'html',
            'email_wrapped' => true,
            'email_unsub' => true
        ];

        if ($emailData['email_format'] == 'html') {
            $html = $app->bbCode()->render(
                    $emailData['email_body'],
                    'emailHtml',
                    'email',
                    null
            );
            $text = $app->mailer()->generateTextBody($html);
        } else {
            $text = $emailData['email_body'];
            $html = null;
        }


        $mail = $app->mailer()->newMail()
                ->setFrom($emailData['from_email'], $emailData['from_name'])
                ->setTo($item->email)
                ->setTemplate('prepared_email', [
                    'title' => $emailData['email_title'],
                    'htmlBody' => $html,
                    'textBody' => $text,
                    'raw' => true
        ]);

        return $mail->send();
    }

    protected function getMail(\XF\Entity\User $user) {
        $mailer = $this->app->mailer();
        $mail = $mailer->newMail();

        $options = $this->app->options();
        $unsubEmail = $options->unsubscribeEmailAddress;
        $useVerp = $options->enableVerp;

        $mail->setToUser($user);

        return $mail->setListUnsubscribe($unsubEmail, $useVerp);
    }

    protected function prepareTokens(\XF\Entity\User $user, $escape) {
        $unsubLink = $this->app->router('public')->buildLink('canonical:email-stop/mailing-list', $user);

        $tokens = [
            '{name}' => $user->username,
            '{email}' => $user->email,
            '{id}' => $user->user_id,
            '{unsub}' => $unsubLink
        ];

        if ($escape) {
            array_walk($tokens, function (&$value) {
                if (is_string($value)) {
                    $value = htmlspecialchars($value);
                }
            });
        }

        return $tokens;
    }
}
