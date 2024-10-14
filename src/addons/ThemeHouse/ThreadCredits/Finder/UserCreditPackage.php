<?php

namespace ThemeHouse\ThreadCredits\Finder;

use XF\Mvc\Entity\Finder;

class UserCreditPackage extends Finder
{
    public function activeOnly(): self
    {
        return $this->whereOr(
            ['expires_at', '>', \XF::$time],
            ['expires_at', '=', 0]
        );
    }

    public function orderByUseFirst(): self
    {
        return $this
            ->order($this->expression('expires_at > 0'), 'asc')
            ->order('expires_at', 'asc')
            ->order('remaining_credits', 'asc');
    }
}