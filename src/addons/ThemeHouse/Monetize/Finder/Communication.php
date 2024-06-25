<?php

namespace ThemeHouse\Monetize\Finder;

use XF\Mvc\Entity\Finder;

class Communication extends Finder
{
    public function activeOnly()
    {
        return $this->where('active', '=', 1);
    }
}