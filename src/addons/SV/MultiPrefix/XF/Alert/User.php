<?php

namespace SV\MultiPrefix\XF\Alert;

use XF\Entity\UserAlert;
use XF\Mvc\Entity\Entity;

/**
 * Extends \XF\Alert\User
 */
class User extends XFCP_User
{
    public function getTemplateData($action, UserAlert $alert, Entity $content = null)
    {
        $retval = parent::getTemplateData($action, $alert, $content);

        if (isset($retval['extra']['prefix_id'], $retval['extra']['sv_prefix_ids']))
        {
            $retval['extra']['prefix_id'] = $retval['extra']['sv_prefix_ids'];
        }

        return $retval;
    }
}