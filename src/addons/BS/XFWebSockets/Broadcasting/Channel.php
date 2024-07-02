<?php

namespace BS\XFWebSockets\Broadcasting;

class Channel
{
    /**
     * The channel's name.
     *
     * @var string
     */
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Convert the channel instance to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
