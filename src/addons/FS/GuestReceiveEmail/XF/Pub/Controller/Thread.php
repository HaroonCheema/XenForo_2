<?php

namespace FS\GuestReceiveEmail\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{

    public function actionGuestEmail(ParameterBag $params)
    {
        $visitor = \XF::visitor();
        if ($visitor->user_id) {
            return $this->noPermission();
        }

        $thread = $this->assertViewableThread($params->thread_id);

        if (!$thread) {
            throw $this->exception($this->notFound(\XF::phrase('requested_thread_not_found')));
        }

        $emailValidator = $this->app->validator('Email');

        $email = $this->filter('email', 'str');
        $email = $emailValidator->coerceValue($email);

        if ($this->isPost() && $emailValidator->isValid($email)) {

            $existEmail = $this->finder('FS\GuestReceiveEmail:GuestEmail')->where('thread_id', $params['thread_id'])->where('email', $email)->fetchOne();

            if (!$existEmail) {
                $insert = $this->em()->create('FS\GuestReceiveEmail:GuestEmail');

                $insert->thread_id = $params['thread_id'];
                $insert->email = $email;
                $insert->save();

                return $this->redirect($this->buildLink('threads', $thread));
            } else {
                throw $this->exception($this->notFound(\XF::phrase('fs_guest_email_already_exist')));
            }
        }

        $viewParams = [
            'thread' => $thread
        ];

        return $this->view('XF:Thread\GuestEmail', 'fs_guest_dialog_box', $viewParams);
    }

    protected function finalizeThreadReply(\XF\Service\Thread\Replier $replier)
    {
        $post = $replier->getPost();

        $app = \XF::app();

        $jopParams = [
            'postId' => $post->post_id,
        ];

        $jobID = $post->post_id . '_guestSendEmail_' . time();

        $app->jobManager()->enqueueUnique($jobID, 'FS\GuestReceiveEmail:guestSendEmail', $jopParams, false);
        // $app->jobManager()->runUnique($jobID, 120);

        return parent::finalizeThreadReply($replier);
    }
}
