<?php

namespace AddonFlare\PaidRegistrations\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

use XF\Mvc\Entity\AbstractCollection;

class Coupon extends Repository
{
    public function findCouponsForAccountType($accountTypeId, $checkUserGroupPerms = true, \XF\Entity\User $user = null)
    {
        $couponFinder = $this->finder('AddonFlare\PaidRegistrations:Coupon');

        $accountTypeIds = [-1, $accountTypeId];

        $utf8type = $this->db()->getUtf8Type();
        $expression = $couponFinder->expression('CONCAT(",", CONVERT (%s USING '.$utf8type.'), ",") REGEXP ",('.implode('|', $accountTypeIds).'),"', 'account_type_ids');

        $couponFinder->where($expression);

        if ($checkUserGroupPerms)
        {
            if (!$user)
            {
                $user = \XF::visitor();
            }

            $userGroupIds = array_merge([-1, $user->user_group_id], $user->secondary_group_ids);

            $expression = $couponFinder->expression('CONCAT(",", CONVERT (%s USING '.$utf8type.'), ",") REGEXP ",('.implode('|', $userGroupIds).'),"', 'user_group_ids');

            $couponFinder->where($expression);
        }

        return $couponFinder;
    }

    public function findActiveCouponsForAccountType($accountTypeId, $checkUserGroupPerms = true, \XF\Entity\User $user = null)
    {
        $couponFinder = $this->findCouponsForAccountType($accountTypeId, $checkUserGroupPerms, $user);

        $couponFinder
            ->where('active', 1)
            ->where('start_date', '<=', \XF::$time)
            ->whereOr([['end_date', '=', 0], ['end_date', '>', \XF::$time]])
            ->whereOr([['unlimited_uses', '=', 1], ['uses_remaining', '>', 0]]);

        return $couponFinder;
    }

    public function getActiveCouponsForAccountType($accountTypeId, $checkUserGroupPerms = true, \XF\Entity\User $user = null)
    {
        $couponFinder = $this->findActiveCouponsForAccountType($accountTypeId, $checkUserGroupPerms, $user);

        // \XF::dump($couponFinder->getQuery());

        $coupons = $couponFinder->fetch();

        // \XF::dump($coupons);

        return $coupons;
    }

    public function getActiveCouponForAccountType($accountTypeId, $couponCode, $checkUserGroupPerms = true, \XF\Entity\User $user = null)
    {
        $couponFinder = $this->findActiveCouponsForAccountType($accountTypeId, $checkUserGroupPerms, $user);

        $couponFinder->where('coupon_code', $couponCode);

        // \XF::dump($couponFinder->getQuery());

        $coupons = $couponFinder->fetchOne();

        // \XF::dump($coupons);

        return $coupons;
    }
}