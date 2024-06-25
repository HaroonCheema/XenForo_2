<?php

namespace NF\GiftUpgrades\XF\Repository;

/**
 * Extends \XF\Repository\UserUpgrade
 */
class UserUpgrade extends XFCP_UserUpgrade
{
    /**
     * @return array
     */
    public function getFilteredUserUpgradesForList()
    {
        list($upgrades, $purchased) = parent::getFilteredUserUpgradesForList();

        if (!empty($purchased))
        {
            foreach ($purchased AS $upgrade)
            {
                /** @var \NF\GiftUpgrades\XF\Entity\UserUpgrade $upgrade */
                $userUpgradeId = $upgrade->user_upgrade_id;
                if (!isset($upgrades[$userUpgradeId]) && $upgrade->canGift())
                {
                    $upgrades[$userUpgradeId] = $upgrade;
                }
            }
        }

        return [$upgrades, $purchased];
    }

    /**
     * @param \XF\Entity\UserUpgradeActive|\NF\GiftUpgrades\XF\Entity\UserUpgradeActive       $active
     * @param \XF\Entity\UserUpgradeExpired|\NF\GiftUpgrades\XF\Entity\UserUpgradeExpired|null $expired
     */
    public function expireActiveUpgrade(\XF\Entity\UserUpgradeActive $active, \XF\Entity\UserUpgradeExpired $expired = null)
    {
        if ($active->is_gift)
        {
            if ($expired === null)
            {
                /** @noinspection CallableParameterUseCaseInTypeContextInspection */
                $expired = $this->em->create('XF:UserUpgradeExpired');
            }

            $expired->is_gift = $active->is_gift;
            $expired->pay_user_id = $active->pay_user_id;
        }

        parent::expireActiveUpgrade($active, $expired);
    }
}