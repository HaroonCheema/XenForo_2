<?php

namespace NF\GiftUpgrades\XF\Search\Data;

use NF\GiftUpgrades\Search\GiftSearcherTrait;
use NF\GiftUpgrades\Search\IGiftSearcher;

/**
 * @extends \XF\Search\Data\ProfilePostComment
 */
class ProfilePostComment extends XFCP_ProfilePostComment implements IGiftSearcher
{
    use GiftSearcherTrait;
}