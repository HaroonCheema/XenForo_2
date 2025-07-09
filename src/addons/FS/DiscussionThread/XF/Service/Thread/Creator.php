<?php

namespace FS\DiscussionThread\XF\Service\Thread;

class Creator extends XFCP_Creator
{
    public function setDiscThreadUser(\XF\Entity\User $user)
    {
        return parent::setUser($user);
    }
}