<?php

namespace FS\UpgradePauseUnpause\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
    public function actionPause(ParameterBag $params)
    {
        $visitor = \XF::visitor();

        $visitor = \XF::visitor();
        if (!$visitor->user_id || (!$visitor->is_admin && !$visitor->is_moderator)) {
            return $this->noPermission();
        }

        $user = $this->assertViewableUser($params->user_id, [], true);

        $alertUser = \XF::finder('FS\UpgradePauseUnpause:AlertPauseUnpause')->where('user_id', $user->user_id)->fetchOne();

        if (!$alertUser) {

            $alertUser = \XF::em()->create('FS\UpgradePauseUnpause:AlertPauseUnpause');

            $alertUser->user_id = $user->user_id;
            $alertUser->save();
        }

        $redirect = $this->getDynamicRedirect(null, false);

        if ($this->isPost()) {

            if (!$user->isPaused()) {

                $app = \XF::app();
                $jobID = "fs_upgrade_pause_" . time();

                $app->jobManager()->enqueueUnique($jobID, 'FS\UpgradePauseUnpause:UserUpgradePause', ['user_id' => $user->user_id], false);
                // $app->jobManager()->enqueueUnique($jobID, 'FS\UpgradePauseUnpause:UserUpgradePause', [], true);
                // $app->jobManager()->runUnique($jobID, 120);


                /** @var User $notifier */
                $notifier = $this->app->notifier('FS\UpgradePauseUnpause:PauseUnpauseAlert');
                $notifier->sendPauseAlert($user);
            } else {

                $app = \XF::app();
                $jobID = "fs_upgrade_unpause_" . time();

                $app->jobManager()->enqueueUnique($jobID, 'FS\UpgradePauseUnpause:UserUpgradeUnpause', ['user_id' => $user->user_id], false);

                /** @var User $notifier */
                $notifier = $this->app->notifier('FS\UpgradePauseUnpause:PauseUnpauseAlert');
                $notifier->sendUnpauseAlert($user);
            }

            $reply = $this->redirect($redirect);
            $reply->setJsonParam('switchKey', $user->isPaused() ? 'fs_pause' : 'fs_unpause');
            return $reply;
        } else {
            $viewParams = [
                'user' => $user,
                'isPaused' => $user->isPaused()
            ];

            return $this->view('FS\UpgradePauseUnpause:Member\Pause', 'fs_upgrade_thread_watch_pause', $viewParams);
        }
    }
}
