<?php

namespace ThemeHouse\Monetize\Repository;

use XF\Mvc\Entity\Repository;

/**
 * Class Coupon
 * @package ThemeHouse\Monetize\Repository
 */
class Coupon extends Repository
{
    /**
     * @return \ThemeHouse\Monetize\Finder\Coupon
     */
    public function findCouponsForList()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->finder('ThemeHouse\Monetize:Coupon')
            ->order('coupon_id');
    }

    public function fetchCoupons()
    {
        $couponFinder = $this->findCouponsForList()->activeOnly();

        $coupons = $couponFinder->fetch();

        return $coupons;
    }
}
