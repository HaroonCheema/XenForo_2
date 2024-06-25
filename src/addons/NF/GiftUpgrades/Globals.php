<?php

namespace NF\GiftUpgrades;

/**
 * Class Globals
 *
 * This class is used to encapsulate global state between layers without using $GLOBAL[] or relying on the consumer
 * being loaded correctly by the dynamic class autoloader
 *
 * @package NF\GiftUpgrades
 */
abstract class Globals
{
    /** @var bool */
    public static $isGift;
    /** @var int */
    public static $payUserId;
    /** @var string */
    public static $payUsername;

    /** @var int */
    public static $giftToUserId;
    /** @var string */
    public static $giftToUsername;

    /** @var int */
    public static $contentId;
    /** @var string */
    public static $contentType;
    /** @var bool */
    public static $isAnonymous;


    private function __construct()
    {
    }
}