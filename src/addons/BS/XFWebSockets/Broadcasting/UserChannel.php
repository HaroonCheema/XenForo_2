<?php

namespace BS\XFWebSockets\Broadcasting;

class UserChannel extends PrivateChannel
{
    public function __construct($id)
    {
        parent::__construct('User.' . $id);
    }

    public function join(\XF\Entity\User $visitor, $id): bool
    {
        return $visitor->user_id === (int)$id;
    }
}