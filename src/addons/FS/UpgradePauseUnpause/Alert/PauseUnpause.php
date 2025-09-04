<?php

namespace FS\UpgradePauseUnpause\Alert;

use XF\Mvc\Entity\Entity;
use XF\Alert\AbstractHandler;

class PauseUnpause extends AbstractHandler
{
    public function getOptOutActions()
    {
        return [
            'pause',
            'unpause'
        ];
    }

    public function getOptOutDisplayOrder()
    {
        return 200;
    }

    public function canViewContent(Entity $entity, &$error = null)
    {
        return true;
    }
}
