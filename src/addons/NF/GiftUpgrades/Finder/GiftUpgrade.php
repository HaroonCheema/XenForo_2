<?php

namespace NF\GiftUpgrades\Finder;

use XF\Mvc\Entity\Finder;

class GiftUpgrade extends Finder
{
    public static function get(): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return \XF::finder('NF\GiftUpgrades:GiftUpgrade');
    }
}