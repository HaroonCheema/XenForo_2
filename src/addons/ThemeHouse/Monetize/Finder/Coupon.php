<?php

namespace ThemeHouse\Monetize\Finder;

use XF\Mvc\Entity\Finder;

/**
 * Class Coupon
 * @package ThemeHouse\Monetize\Finder
 */
class Coupon extends Finder
{
    /**
     * @return $this
     */
    public function activeOnly()
    {
        $this->where('active', 1);

        return $this;
    }

    /**
     * @return $this
     */
    public function byCode($code)
    {
        $this->where('code', $code);

        return $this;
    }
}
