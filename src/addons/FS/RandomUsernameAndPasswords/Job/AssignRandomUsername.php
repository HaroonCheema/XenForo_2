<?php

namespace FS\RandomUsernameAndPasswords\Job;

use XF\Job\AbstractJob;

class AssignRandomUsername extends AbstractJob
{
    protected $defaultData = [
        'limit' => 1000,
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);

        $options = \XF::options();

        if (empty($options->fs_random_username_user_ids)) {
            return $this->complete();
        }

        $userIds = array_filter(array_map('trim', explode(',', $options->fs_random_username_user_ids)));

        $getUsers = \XF::finder('XF:User')->where('user_id', $userIds)->fetch();

        if (!$getUsers->count()) {

            return $this->complete();
        }

        $limit = $this->data['limit'];

        $getPendingUsers = \XF::finder('XF:User')->where('user_id', '!=', $userIds)->where('is_renamed', 0)->limit($limit)->fetch();

        if (!$getPendingUsers->count()) {

            return $this->complete();
        }

        foreach ($getPendingUsers as $i => $user) {

            /** @var \FS\RandomUsernameAndPasswords\Service\RandomUsernamePasswords $reputationdServ */
            $reputationdServ = \XF::service('FS\RandomUsernameAndPasswords:RandomUsernamePasswords');

            $reputationdServ->changeUsernamePassword($user);


            if (microtime(true) - $startTime >= $maxRunTime) {
                break;
            }
        }

        return $this->resume();
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
