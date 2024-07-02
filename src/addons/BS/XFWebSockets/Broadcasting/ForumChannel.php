<?php

namespace BS\XFWebSockets\Broadcasting;

class ForumChannel extends PrivateChannel
{
    public function __construct(string $name = '')
    {
        parent::__construct($name ?: 'Forum');
    }

    public function join(\XF\Entity\User $visitor): bool
    {
        return $visitor->hasPermission('websockets', 'use');
    }
}
