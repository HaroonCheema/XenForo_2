<?php

namespace AddonFlare\PaidRegistrations\Alert;

use XF\Mvc\Entity\Entity;

class UserUpgrade extends \XF\Alert\AbstractHandler
{
    public function canViewContent(Entity $entity, &$error = null)
    {
        return true;
    }
}
