<?php

namespace NF\GiftUpgrades\XF\Search\Data;

use NF\GiftUpgrades\Search\GiftSearcherTrait;
use NF\GiftUpgrades\Search\IGiftSearcher;

/**
 * @extends \XF\Search\Data\Post
 */
class Post extends XFCP_Post implements IGiftSearcher
{
    use GiftSearcherTrait;
}