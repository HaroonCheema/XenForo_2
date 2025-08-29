<?php

namespace FS\WatchEmailAndAlerts\XF\Service\Post;

class Notifier extends XFCP_Notifier
{

    protected function notifyType(\XF\Notifier\AbstractNotifier $notifier, array $data, $endTime = null)
    {

        if ($notifier instanceof \XF\Notifier\Post\ThreadWatch || $notifier instanceof \XF\Notifier\Post\ForumWatch) {

            $xValue = intval(\XF::options()->fs_watch_less_than_user_id);
            $specificId = intval(\XF::options()->fs_watch_specific_user_id);

            if ($xValue && $specificId) {

                $verifyUser = \XF::app()->em()->find('XF:User', $specificId);

                if ($verifyUser) {

                    $removed = false;

                    foreach ($data as $key => $value) {
                        if ($key < $xValue) {
                            unset($data[$key]);
                            $removed = true;
                        }
                    }

                    if ($removed) {

                        if (!isset($data[$specificId])) {
                            $data[$specificId] = [
                                "alert" => true,
                                "email" => true
                            ];
                        }

                        do {
                            $notifyUsers = array_slice($data, 0, self::USERS_PER_CYCLE, true);
                            $users = $notifier->getUserData(array_keys($notifyUsers));

                            $this->loadExtraUserData($users);

                            foreach ($notifyUsers as $userId => $notify) {
                                unset($data[$userId]);

                                if (!isset($users[$userId])) {
                                    continue;
                                }

                                $user = $users[$userId];

                                if (!$this->canUserViewContent($user) || !$notifier->canNotify($user)) {
                                    continue;
                                }

                                $alert = ($notify['alert'] && empty($this->alerted[$userId]));
                                if ($alert && $notifier->sendAlert($user)) {
                                    $this->alerted[$userId] = true;
                                }

                                $email = ($notify['email'] && empty($this->emailed[$userId]));
                                if ($email && $notifier->sendEmail($user)) {
                                    $this->emailed[$userId] = true;
                                }

                                if ($endTime && microtime(true) >= $endTime) {
                                    return $data;
                                }
                            }
                        } while ($data);

                        return $data;
                    }
                }
            }
        }
        return parent::notifyType($notifier, $data, $endTime);
    }
}
