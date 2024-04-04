<?php

namespace FS\GuestReceiveEmail\Job;

use XF\Job\AbstractJob;

class guestSendEmail extends AbstractJob
{
    protected $defaultData = [];

    public function run($maxRunTime)
    {
        $s = microtime(true);
        $app = \xf::app();

        $postId = $this->data['postId'];

        $post = $app->finder('XF:Post')->where('post_id', $postId)->fetchOne();

        if ($post) {

            $guestEmails = $app->finder('FS\GuestReceiveEmail:GuestEmail')->where('thread_id', $post->Thread->thread_id)->fetch();

            foreach ($guestEmails as $guest) {

                $this->sendEmail($post, $guest->email);
            }
        }

        return $this->complete();
    }

    public function sendEmail($post, $email)
    {
        $app = \xf::app();

        $params = [
            'post' => $post,
            'thread' => $post->Thread,
            'forum' => $post->Thread->Forum,
            'receiver' => "Guest"
        ];

        $template = 'fs_guest_watched_thread_reply';

        $app->mailer()->newMail()
            ->setTo($email)
            ->setTemplate($template, $params)
            ->queue();

        return true;
    }

    public function getStatusMessage()
    {
    }

    public function canCancel()
    {
        return true;
    }

    public function canTriggerByChoice()
    {
        return true;
    }
}
