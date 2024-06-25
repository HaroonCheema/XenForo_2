<?php

namespace NF\GiftUpgrades\XF\Search\Data;

use NF\GiftUpgrades\Search\GiftSearcherTrait;
use NF\GiftUpgrades\Search\IGiftSearcher;

/**
 * @extends \XF\Search\Data\ProfilePost
 */
class ProfilePost extends XFCP_ProfilePost implements IGiftSearcher
{
    use GiftSearcherTrait;
}