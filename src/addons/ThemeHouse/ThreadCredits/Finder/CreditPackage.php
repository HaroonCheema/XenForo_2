<?php

namespace ThemeHouse\ThreadCredits\Finder;

use XF\Mvc\Entity\Finder;

class CreditPackage extends Finder
{
    public function purchasableOnly(): self
    {
        return $this->where('can_purchase', '=', 1);
    }
}