<?php

namespace NF\GiftUpgrades\Search;

use XF\Mvc\Entity\AbstractCollection;

interface IGiftSearcher
{
    public function hasCategorySupport(): bool;
    public function getGiftCategoriesForSearch(): AbstractCollection;
}