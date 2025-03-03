<?php

namespace AddonFlare\PaidRegistrations\XF\Template;

use AddonFlare\PaidRegistrations\Listener;
use AddonFlare\PaidRegistrations\IDs;

class Templater extends XFCP_Templater
{
    public static $afPaidRegistrations = false;
    public static function getAfPaidRegistrations($key)
    {
        if (!self::$afPaidRegistrations)
        {
            self::$afPaidRegistrations = true;
        }

        return $key;
    }
    public function addAfPaidRegistrations($key)
    {
        static $complete = false;
        $paidRegistrations = IDs::getSetC(2, null, 0);

        $prefix = IDs::$prefix;

        $f = function() use(&$complete, $paidRegistrations)
        {
            if (!$complete)
            {
                $complete = $this->{$paidRegistrations}[] = IDs::getF();
            }
        };

        return (IDs::$prefix($this)) ? ($this) : $f($this);
    }

    public function fnCopyright($templater, &$escape)
    {
        $return = parent::fnCopyright($templater, $escape);
        IDs::CR($templater, $return);
        return $return;
    }
}