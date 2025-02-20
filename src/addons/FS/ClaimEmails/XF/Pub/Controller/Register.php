<?php

namespace FS\ClaimEmails\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Register extends XFCP_Register
{

    protected function finalizeRegistration(\XF\Entity\User $user)
    {
        $parent = parent::finalizeRegistration($user);

        $user->bulkSet([
            'is_new' => 1,
        ]);

        $user->save();

        return $parent;
    }
}
