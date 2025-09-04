<?php

namespace FS\UpgradePauseUnpause\Notifier;

use XF\Notifier\AbstractNotifier;

class PauseUnpauseAlert extends AbstractNotifier
{
    private $alertUser;

    public function __construct(\XF\App $app)
    {
        parent::__construct($app);

        // $this->alertUser = $alertUser;
    }

    public function canNotify(\XF\Entity\User $user)
    {
        return true;
    }

    public function sendPauseAlert(\XF\Entity\User $user)
    {
        $visitor = \XF::visitor();

        $alertUser = \XF::finder('FS\UpgradePauseUnpause:AlertPauseUnpause')->where('user_id', $user->user_id)->fetchOne();

        return $this->basicAlert(
            $user,
            $visitor->user_id,
            $visitor->username,
            'dummy_entity',
            $alertUser->id,
            'pause',
            []
        );
    }

    public function sendUnpauseAlert(\XF\Entity\User $user)
    {

        $visitor = \XF::visitor();

        $alertUser = \XF::finder('FS\UpgradePauseUnpause:AlertPauseUnpause')->where('user_id', $user->user_id)->fetchOne();

        return $this->basicAlert(
            $user,
            $visitor->user_id,
            $visitor->username,
            'dummy_entity',
            $alertUser->id,
            'unpause',
            []
        );
    }
}
