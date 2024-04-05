<?php

namespace FS\GuestReceiveEmail\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{

    public function actionGuestEmail(ParameterBag $params)
    {
        if (!$this->request->getCookie('fs_guest_unique_id')) {
            $token = uniqid();

            $this->app->response()->setCookie(
                'fs_guest_unique_id',
                $token,
                \XF::$time + 86400 * 365
            );
        }

        $visitor = \XF::visitor();
        if ($visitor->user_id) {
            return $this->noPermission();
        }

        $thread = $this->assertViewableThread($params->thread_id);

        if (!$thread) {
            throw $this->exception($this->notFound(\XF::phrase('requested_thread_not_found')));
        }

        $guestId =  $this->request->getCookie('fs_guest_unique_id');

        $alreadyExist = $this->finder('FS\GuestReceiveEmail:GuestEmail')->where('thread_id', $thread->thread_id)->where('guest_id', $guestId)->fetchOne();

        if ($alreadyExist) {
            throw $this->exception($this->notFound(\XF::phrase('fs_guest_no_permission')));
        }

        $emailValidator = $this->app->validator('Email');

        $email = $this->filter('email', 'str');
        $email = $emailValidator->coerceValue($email);

        if ($this->isPost() && $emailValidator->isValid($email)) {

            if (!$this->captchaIsValid()) {
                return $this->error(\XF::phrase('did_not_complete_the_captcha_verification_properly'));
            }

            $existEmail = $this->finder('FS\GuestReceiveEmail:GuestEmail')->where('thread_id', $params['thread_id'])->where('email', $email)->fetchOne();

            if (!$existEmail) {

                $guestId =  $this->request->getCookie('fs_guest_unique_id');

                $insert = $this->em()->create('FS\GuestReceiveEmail:GuestEmail');

                $insert->guest_id = $guestId;
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

    public function actionGuestRemoveEmail(ParameterBag $params)
    {
        $thread = $this->assertViewableThread($params->thread_id);

        if (!$thread) {
            throw $this->exception($this->notFound(\XF::phrase('requested_thread_not_found')));
        }

        $guestId =  $this->request->getCookie('fs_guest_unique_id');

        if (!$guestId) {
            throw $this->exception($this->notFound(\XF::phrase('fs_guest_id_not_found')));
        }

        $existGuest = $this->finder('FS\GuestReceiveEmail:GuestEmail')->where('thread_id', $params['thread_id'])->where('guest_id', $guestId)->fetchOne();

        if (!$existGuest) {
            throw $this->exception($this->notFound(\XF::phrase('fs_guest_email_not_found')));
        }

        if ($this->isPost()) {
            $existGuest->delete();

            return $this->redirect($this->buildLink('threads', $thread));
        }

        $viewParams = [
            'thread' => $thread,
            'email' => $existGuest['email'],
        ];

        return $this->view('XF:Thread\GuestRemoveEmail', 'fs_guest_delete_email', $viewParams);
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
