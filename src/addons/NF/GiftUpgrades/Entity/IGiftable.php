<?php

namespace NF\GiftUpgrades\Entity;

use NF\GiftUpgrades\Gift\AbstractHandler;
use XF\Mvc\Entity\AbstractCollection;

/**
 * Interface IGiftable
 * GETTERS
 *
 * @property-read int $GiftCount
 * RELATIONS
 * @property-read AbstractCollection|GiftUpgrade[] $Gifts
 */
interface IGiftable
{
    /**
     * @param string|\XF\Phrase|null $error
     * @return bool
     */
    public function canGiftTo(&$error = null): bool;

    /**
     * @param string|\XF\Phrase|null $error
     * @return bool
     */
    public function canViewGiftsList(&$error = null): bool;

    public function getGiftHandler(): ?AbstractHandler;

    public function getGiftCount(): int;
}
