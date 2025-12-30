<?php

declare(strict_types=1);

namespace ScriptsPages\XF\Mvc\Reply;

use XF\Mvc\Reply\AbstractReply;

class Raw extends AbstractReply {
    protected $message = '';

    public function __construct($message, $responseCode = 200)
    {
        $this->setMessage($message);
        $this->setResponseCode($responseCode);
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}