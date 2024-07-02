<?php

namespace BS\XFWebSockets\Broadcasting;

class PresenceChannel extends Channel
{
    public function __construct($name)
    {
        parent::__construct('presence-'.$name);
    }
}
