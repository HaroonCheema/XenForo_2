<?php

namespace NF\GiftUpgrades;

use NF\GiftUpgrades\XF\Entity\User as ExtendedUserEntity;
use XF\Entity\User;

/**
 * Class Listener
 *
 * @package NF\GiftUpgrades
 */
abstract class Listener
{
    /**
     * @param string                  $rule
     * @param array                   $data
     * @param User|ExtendedUserEntity $user
     * @param bool                    $returnValue
     */
    public static function criteriaUser(string $rule, array $data, User $user, bool &$returnValue): void
    {
        if (!$user->user_id)
        {
            return;
        }

        switch ($rule)
        {
            case 'giftupgrades_gift_received_count':
                $returnValue = $user->gift_received_count >= $data['count'];
                break;

            case 'giftupgrades_gift_given_count':
                $returnValue = $user->gift_given_count >= $data['count'];
                break;
        }
    }
}