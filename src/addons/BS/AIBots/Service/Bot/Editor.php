<?php

namespace BS\AIBots\Service\Bot;

use BS\AIBots\Entity\Bot;

class Editor extends Creator
{
    public function __construct(\XF\App $app, Bot $bot)
    {
        parent::__construct($app);
        $this->bot = $bot;
    }

    public function setUsername(string $username)
    {
        throw new \LogicException('Cannot change username of an existing bot');
    }
}