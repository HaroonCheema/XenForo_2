<?php

namespace NF\GiftUpgrades\Stats;

use XF\Stats\AbstractHandler;

/**
 * Class GiftUpgrade
 *
 * @package NF\GiftUpgrades\Stats
 */
class GiftUpgrade extends AbstractHandler
{
    public function getStatsTypes(): array
    {
        return [
            'nixfifty_gift_upgrade' => \XF::phrase('nf_giftupgrades_gift_upgrade'),
        ];
    }

    /**
     * @param int $start
     * @param int $end
     *
     * @return array
     */
    public function getData($start, $end): array
    {
        $db = $this->db();

        $giftUpgrades = $db->fetchPairs(
            $this->getBasicDataQuery('xf_nixfifty_gift_upgrade_statistics', 'stat_date'),
            [$start, $end]
        );

        return [
            'nixfifty_gift_upgrade' => $giftUpgrades,
        ];
    }
}