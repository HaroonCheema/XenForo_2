<?php

namespace BS\AIBots\Exception;

// Exception for when a bot should rehandle a message
class ShouldRehandleException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}