<?php

namespace AddonFlare\PaidRegistrations\Alert;

use XF\Mvc\Entity\Entity;

class GiftUpgrade extends \XF\Alert\AbstractHandler
{
    public function canViewContent(Entity $entity, &$error = null)
    {
        return true;
    }
}
